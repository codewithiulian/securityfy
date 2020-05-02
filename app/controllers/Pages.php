<?php

class Pages extends Controller {

  public function __construct(){
    $this->userModel = $this->model('User');
    $this->itemModel = $this->model('Item');
  }

  // Functionality for the Dashboard page
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
    // Load the dashboard.
    $this->view('pages/dashboard', $data);
  }

  public function add() {
    // Redirect if not logged in.
    if(!isLoggedIn()) redirect('pages/index');

    // Load the add view.
    $this->view('pages/add');
  }

  // Functionality for the Profile page.
  public function profile(){
    // Redirect if not logged in.
    if(!isLoggedIn()) redirect('pages/index');

    $data = [
      'firstName' => $_SESSION['firstName'],
      'lastName' => $_SESSION['lastName'],
      'fullName' => $_SESSION['fullName'],
      'email' => $_SESSION['email'],
      'registeredOn' => $_SESSION['registeredOn']
    ];

    // Load the profile view.
    $this->view('pages/profile', $data);
  }

  public function index(){
    $this->view('pages/index');
  }
}