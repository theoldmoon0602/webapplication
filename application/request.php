<?php

/**
 * HTTP Request object 
 */
class Request {
  public $method;
  public $path;
  public $cookie;
  public $session;
  public $params;
  public $fragment;
  public $query;
  public $post;
  public $body;

  public function __construct($method, $path, $fragment, $params, $query, $post, $body, $cookie, $session) {
    $this->method = $method;
    $this->path = $path;
    $this->params = $params;
    $this->query = $query;
    $this->post = $post;
    $this->body = $body;
    $this->fragment = $fragment;
    $this->cookie = $cookie;
    $this->session = $session;
  }


  public function getParam($key, $default = null) {
    return isset($this->params[$key]) ? $this->params[$key] : $default;
  }

  public function getQuery($key, $default = null) {
    return isset($this->query[$key]) ? $this->query[$key] : $default;
  }

  public function getQueries() {
    return $this->query;
  }

  public function getPost($key, $default = null) {
    return isset($this->post[$key]) ? $this->post[$key] : $default;
  }

  public function getPosts() {
    return $this->post;
  }

  public function getCookie($key, $default = null) {
    return isset($this->cookie[$key]) ? $this->cookie[$key] : $default;
  }

  public function getSession($key, $default = null) {
    return isset($this->session[$key]) ? $this->session[$key] : $default;
  }

  public function getJSON() {
    return json_encode($this->body, true);
  }

  public function getBody() {
    return $this->body;
  }

  public function getParams() {
    return $this->params;
  }

  public function getFragement() {
    return $this->fragment;
  }

}
