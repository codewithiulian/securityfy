<?php

/**
 * Base Controller.
 * Loads Models and Views.
 */
class Controller
{

  /**
   * Loads and initializes the model passed in as a parameter.
   */
  public function model($model)
  {
    $fileRequested = '../app/models/' . $model . '.php';
    // If the model exists.
    if (file_exists($fileRequested)) {
      // Require it.
      require_once $fileRequested;
      return new $model();
    } else {
      die('Model ' . $model . ' does not exist.');
    }
  }

  /**
   * Loads and initializes the view.
   * $view - view name.
   * $data - optional array to pass data through.
   */
  public function view($view, $data = [])
  {
    $fileRequested = '../app/views/' . $view . '.php';
    if (file_exists($fileRequested)) {
      require_once $fileRequested;
    } else {
      die('View ' . $view . ' does not exist.');
    }
  }

  /**
   * Loads and initializes a domain.
   * $domain - domain name.
   * $data - optional array to pass data through.
   */
  public function domain($domain, $data = [])
  {
    $fileRequested = '../app/domains/' . $domain . '.php';
    // If the domain exists.
    if (file_exists($fileRequested)) {
      // Require it.
      require_once $fileRequested;
      return new $domain();
    } else {
      die('Domain ' . $domain . ' does not exist.');
    }
  }
}
