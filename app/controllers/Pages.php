<?php

class Pages extends Controller {

  public function __construct(){
    $this->userModel = $this->model('User');
    $this->itemModel = $this->model('Item');
  }

  public function dashboard(){
    // Redirect if not logged in.
    if(!isLoggedIn()) redirect('pages/index');

    $data = [
      'firstName' => $_SESSION['firstName'],
      'lastName' => $_SESSION['lastName'],
      'fullName' => $_SESSION['fullName'],
      'email' => $_SESSION['email'],
      'registeredOn' => $_SESSION['registeredOn']
    ];
    $this->view('pages/dashboard', $data);
  }

  public function index(){
    $this->view('pages/index');
  }
}