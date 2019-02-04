<?php

/**
 * Router class
 * routing request by method(GET, POST, ...) and path (/hoge or /piyo/tako) * features:
 *  - named routes
 *  - use regex in route specification
 */
class Router {

	protected $routes;
	protected $basePath = '';

  public function __construct($basePath = '') {
    $this->basePath = $basePath;
    $this->routes = [];
  }

	public function setBasePath($basePath) {
		$this->basePath = $basePath;
	}

	public function addRoute($method, $path, $name) {
    $this->routes[] = [
      'method' => $method,
      'path' => $path,
      'name' => $name
    ];
	}

  /**
   * generate url from route name
   */
	public function genURL($routeName, $params = []) {
    $route = null;

    // search named route
    foreach ($this->routes as $r) {
      if ($r['name'] == $routeName) {
        $route = $r;
        break;
      } 
    }
    if (is_null($route)) {
			throw new Exception("Undefined route: $routeName");
    }

    // add url prefix
		$url = $this->basePath . $route['path'];

    // search {pattern} from url
    preg_match_all("@({[A-Za-z0-9-_]+})@", $route['path'], $matches, PREG_SET_ORDER);
		if (count($matches) !== count($params)) {
      throw new Exception("parameter count mismatched for route: $routeName");
    }

    // replace parameter names to values
    foreach($matches as $index => $match) {
      $pattern = $match[3];
      $key = substr($pattern, 1, -1);
      if (! isset($params[$key])) {
        throw new Exception("parameter for $key is not set");
      }

      $url = str_replace($pattern, $params[$key], $url);
		}

		return $url;
	}

	public function match($method, $path) {
    // dummy url for parse_url
    $url = "http://example.com" . $path;
    $url = parse_url($url);
    if ($url === FALSE) {
      throw new Exception("Invalid path: $path");
    }

    // parse url to parts
    $path = substr($url['path'], strlen($this->basePath));
    $query = (isset($url['query'])) ? $url['query'] : '';
    $fragment = (isset($url['fragment'])) ? $url['fragment'] : '';

    // matching routes
		foreach($this->routes as $route) {
      if ($route['method'] !== $method) {
        continue;
      }

      preg_match_all("@{([A-Za-z0-9-_]+)}@", $route['path'], $keys, PREG_SET_ORDER);  // save parameter names
      $regex = preg_replace("@{[A-Za-z0-9-_]+}@", "([A-Za-z0-9-_]+)", $route['path']);  // replace parameter syntax to regex syntax
      if (preg_match_all("@^$regex$@", $path, $matches, PREG_SET_ORDER)) {
        // set parameters
        $params = [];
        for ($i = 0; $i < count($keys); $i++) {
          $params[$keys[$i][1]] = $matches[$i][1];
        }

        return [
          'name' => $route['name'],
          'params' => $params,
          'path' => $path,
          'method' => $method,
          'query' => $query,
          'fragment' => $fragment,
        ];
      }
		}
    return false;
	}

}
