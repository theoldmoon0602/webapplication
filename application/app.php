<?php

require(__DIR__ . '/router.php');
require(__DIR__ . '/renderer.php');
require(__DIR__ . '/request.php');
require(__DIR__ . '/response.php');
require(__DIR__ . '/exception.php');

/**
 * application
 */
class App {
  protected $router;
  protected $renderer;
  protected $actions;
  protected $handlers;

  public function __construct($basePath = '', $templatePath='') {
    $this->router = new Router($basePath);
    $this->renderer = new PHPRenderer($templatePath);
    $this->actions = [];
    $this->handlers = [];
  }

  public function render($req, $template, $vars = []) {
    $vars['app'] = $this;
    $vars['session'] = $req->session;
    return $this->renderer->renderTemplate($template, $vars);
  }

  public function redirect($name, $request, $params=[]) {
    $request->params = $params;
    return $this->process($name, $request);
  }

  public function write($res) {
    // set cookie and session
    $_COOKIE = $res->req->cookie;
    $_SESSION = $res->req->session;

    // write response
    http_response_code($res->code);
    echo $res->body;
  }

  /**
   * why do you want to call this function ... ?
   */
  public function writeBody($body) {
    echo $body;
  }

  /**
   * process request and write response out
   */
  public function run() {
    session_start();

    // match requested url to routes
    $route = $this->router->match($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
    if ($route === false) {
      throw new NotFoundException("404 Not Found");
    }
    $name = $route['name'];

    // create Request object
    $body = file_get_contents('php://input');
    $cookie = $_COOKIE;
    $session = $_SESSION;
    $request = new Request($route['method'], $route['path'], $route['fragment'],
      $route['params'], $_GET, $_POST, $body, $cookie, $session);

    return $this->process($name, $request);
  }

  /**
   * process the route
   */
  protected function process($name, $request) {
    // check action
    if (! isset($this->actions[$name])) {
      throw new Exception("No actions registered for route {$route['name']}"); 
    }
    $action = $this->actions[$name];

    // create pipeline
    $next_func = function($req) use($action) {
      return call_user_func_array($action, [$req] + $req->getParams());
    };

    foreach ($this->handlers[$name] as $handler) {
      $next_func = function($req) use($handler, $next_func) {
        return call_user_func($handler, $req, $next_func);
      };
    }

    // do pipeline and got response
    $response = call_user_func($next_func, $request);
    if (! $response instanceof Response) {
      $response = new Response($response, $request); 
    }

    return $response;
  }

  public function addRoute($name, $method, $path, $action, $handlers = []) {
    $this->router->addRoute($method, $path, $name);

    // add handlers to name
    if (!isset($this->handlers[$name])) {
      $this->handlers[$name] = [];
    }
    foreach ($handlers as $handler) {
      $this->handlers[$name] []= $handler;
    }

    // register action
    $this->actions[$name] = $action;
  }

  public function addRouteGroup($routes, $handlers = []) {
    foreach ($routes as $route) {
      $this->addRoute($route[0], $route[1], $route[2], $route[3], $handlers);
    }
  }

  public function urlFor($name, $params = []) {
    return $this->router->genURL($name, $params);
  }
}
