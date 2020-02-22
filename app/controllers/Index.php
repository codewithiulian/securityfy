<?php

class Index extends Controller {
  public function __construct() {
    $this->itemsModel = $this->model('Item');
  }

  public function index() {
    // Have a custom URL (domain.com/username/index)
    // Get the username parameter from the url and use it to return the user id.
    // Get that user's items based on the user id and generate a readonly page with them.
    $data = [
      'items' => $this->itemsModel->getItems(1)
    ];
    $this->view('pages/index', $data);
  }
}