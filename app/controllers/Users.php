<?php

class Users extends Controller {

  public function __construct(){
    $this->usersModel = $this->model('User');
  }

  public function index(){
    echo 'users index';
  }

  public function login(){
    echo 'users login';
  }

  public function register(){
    $this->usersView = $this->view('users/register');
  }

  public function createUserSession($user){

  }

  public function logout(){
    
  }
}