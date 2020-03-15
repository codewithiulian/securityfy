<?php

class Pages extends Controller {

  public function __construct(){
    $this->userModel = $this->model('User');
    $this->itemModel = $this->model('Item');
  }

  public function dashboard(){
    if(!isLoggedIn()) $this->view('users/login');
    $this->view('pages/dashboard');
  }

  public function index(){
    $this->view('pages/index');
  }
}