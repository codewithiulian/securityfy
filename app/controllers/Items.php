<?php

class Items extends Controller {
  public function __construct() {
    $this->itemsModel = $this->model('Item');
  }

  public function index(){
    $data = [
      'items' => $this->itemsModel->getItems(1)
    ];
    $this->itemsView = $this->view('pages/items', $data);
  }

  public function hello($parameters){
    echo 'Hello method within Items controller!';
  }
}