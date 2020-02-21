<?php

class Products {
  public function __construct() {
    echo 'Products page loaded <br>';
  }

  public function index(){
    echo 'Default function loaded';
  }

  public function hello($parameters){
    echo 'Hello method within Products controller!';
  }
}