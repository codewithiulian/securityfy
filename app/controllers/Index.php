<?php

class Index extends Controller {
  public function __construct() {
    $this->itemsModel = $this->model('Item');
  }

  public function index() {
    $this->view('pages/index');
  }
}