<?php

/**
 * render php file with arguments
 */
class PHPRenderer {
  protected $base;
  public function __construct($base) {
    $this->base = $base;
  }

  function renderTemplate() {
    if (!function_exists("o")) {
      function o($x) {
        echo htmlspecialchars($x);
      }
    }

    ob_start();

    // extract variables at local scope
    if (func_num_args() > 1) {
      extract(func_get_arg(1));
    }
    try {
      include($this->base . func_get_arg(0));
      $ret = ob_get_clean();
    }
    catch(Exception $e) {
      ob_end_clean();
      throw $e;
    }

    return $ret;
  }
}
