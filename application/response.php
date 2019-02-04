<?php

/**
 * HTTP Response Object
 */
class Response {
  public $body;
  public $req;
  public $code;

  public function __construct($body, $req, $code = 200) {
    $this->body = $body;
    $this->req = $req;
    $this->code = $code;
  }

}
