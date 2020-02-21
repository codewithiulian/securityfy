<?php
/**
 * App Core Class
 * Creates URL and loads Core controller.
 * Initializes the Controllers.
 * URL FORMAT - /controller/method/params
 */
class Core {
  protected $currentController = 'Products'; // The default controller page when value is not given.
  protected $currentMethod = 'index'; // index method for default loading within the given controller.
  protected $parameters = []; // The list of parameters, empty by default.

  /**
   * Constructor of class Core.
   */
  public function __construct() {
    $url = $this->getURL(); // Get the URL and store it in a local variable.

    $this->initController($url); // Define and initialise the given Controller.
    $this->initMethod($url); // Define the given method.
    $this->getParameters($url); // Get the parameters.
    $this->callUserFunction(); // Request the method within th given Controller and pass in the parameters.
  }

  /**
   * Deconstruct the URL and return an array of parameters.
   * The first parameter is the controller/page.
   * The second parameter is the method name.
   * Returns the $url array. 
   */
  private function getURL(){
    if(isset($_GET['url'])){ // If the URL is set.
      $url = rtrim($_GET['url'], '/'); // Trim the URL by /.
      $url = filter_var($url, FILTER_SANITIZE_URL); // Sanitize the content.
      $url = explode('/', $url); // Cast into an array by /.

      return $url;
    }
  }

  /**
   * Initialise the first part of the URL which is the Controller name.
   * Takes in the $url which is the URL array.
   */
  private function initController($url) {
    if(isset($url[0])){ // If the url index is not null (Controller name).
      $controllerName = ucwords($url[0]); // Define the controller name.
      // If the file exists in the current directory.
      if(file_exists('../app/controllers/' . $controllerName . '.php')){
        // Define the currentController as the given string.
        $this->currentController = $controllerName;

        unset($url[0]); // Unset the array index in-place.
      }
    }

    // Either way, require the controller.
    require_once '../app/controllers/' . $this->currentController . '.php';
    // Initialise the controller class i.e. $products = new Products().
    $this->currentController = new $this->currentController;
  }

  /**
   * Initializes the second part of the url which is the Method.
   * Takes in the $url which is the URL array.
   */
  private function initMethod($url) {
    if(isset($url[1])){ // If the method name is not null.
      $methodName = $url[1]; // Define the method name.
      // If the method exists within the current controller.
      if(method_exists($this->currentController, $methodName)){
        $this->currentMethod = $methodName; // Define our current method.

        unset($url[1]); // Set the second index to null in-place.
      }
    }
  }

  private function getParameters(&$url) {
    // Define the parameters class property if any are given.
    $this->parameters = $url ? array_values($url) : [];
  }

  private function callUserFunction() {
    // Call the function passing in the array of parameters.
    call_user_func_array([$this->currentController, $this->currentMethod], $this->parameters);
  }

}