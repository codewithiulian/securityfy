<?php

class Products extends Controller {
  public function __construct() {
    $this->productModel = $this->model('Product');
  }

  public function index(){
    // echo 'Default function loaded';
  }

  public function hello($parameters){
    echo 'Hello method within Products controller!';
  }
}