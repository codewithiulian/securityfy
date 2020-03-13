<?php

class Users extends Controller {

  public function __construct(){
    $this->userModel = $this->model('User');
  }

  public function index(){
    echo 'users index';
  }

  public function login(){
    $this->view('users/login');
  }

  public function register(){
    // When the form gets POSTed.
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      // Sanitise the fields.
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); // https://www.php.net/manual/en/function.filter-input-array.php
      
      // Initialise the data object array.
      $data = $this->defineDataObject($_POST);

      // Validate fields if left empty.
      $this->validateFieldsForEmpty($data);
      // Check if email already in use.
      $this->validateUserEmail($data);
      // Validate password.
      $this->validateUserPasword($data);
      
      // If the validation stage is passed.
      if($this->formPassedValidation($data)){
        // Hash the password.
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT); // https://www.php.net/manual/en/function.hash.php

        // Register the user.
        if($this->userModel->register($data)){
          redirect('users/login');
        }else{
          die('Something went wrong with your request. Please try again.');
        }
      }else{ // If any errors.
        $this->view('users/register', $data);
      }
    }else{
      // Initialise empty data object array.
      $data = $this->initDataObject();
      // Load the register view with the default data.
      $this->view('users/register', $data);
    }
  }

  /**
   * Returns True if all the fields passed validation.
   * False if any of the errors has text.
   */
  private function formPassedValidation($data){
    return empty($data['firstNameError'])
        && empty($data['lastNameError'])
        && empty($data['emailError'])
        && empty($data['passwordError'])
        && empty($data['confirmedPasswordError']);
  }

  private function initDataObject(){
    return [
      'firstName' => '',
      'lastName' => '',
      'email' => '',
      'password' => '',
      'confirmedPassword' => '',
      'firstNameError' => '',
      'lastNameError' => '',
      'emailError' => '',
      'passwordError' => '',
      'confirmedPasswordError' => ''
    ];
  }

  private function defineDataObject($postData){
    return [
      'firstName' => trim($postData['firstName']),
      'lastName' => trim($postData['lastName']),
      'email' => trim($postData['email']),
      'password' => trim($postData['password']),
      'confirmedPassword' => trim($postData['confirmedPassword']),
      'firstNameError' => '',
      'lastNameError' => '',
      'emailError' => '',
      'passwordError' => '',
      'confirmedPasswordError' => ''
    ];
  }

  private function validateUserPasword(&$data){
    // Check for password complexity.
    if(strlen($data['password']) < 6){ // If the password is less than 6 characters long.
      $data['passwordError'] = 'Your password must be at least 6 characters long (have an uppercase letter and contain a number).';
    }elseif(!preg_match('~[0-9]+~', $data['password'])){ // If the password does not contain a number (https://www.php.net/manual/en/function.preg-match.php).
      $data['passwordError'] = 'Your password must contain a number (have an uppercase letter and be at least 6 characters long).';
    }elseif(!preg_match('/[A-Z]/', $data['password'])){ // Check for uppercase.
      $data['passwordError'] = 'Your password must contain an uppercase letter (contain a number and be at least 6 characters long).';
    }
    // Password confirmation matching check.
    if($data['password'] != $data['confirmedPassword']){
      $data['confirmedPasswordError'] = 'The passwords do not match.';
    }
  }

  private function validateUserEmail(&$data){
    if($this->userModel->isEmailInUse($data['email'])) $data['emailError'] = 'This email address is already in use.';
  }

  private function validateFieldsForEmpty(&$data){ // Pass data obj by reference and define errors in place.
    // https://www.php.net/manual/ro/language.references.pass.php
    // Fields validation.
    if(empty($data['firstName'])){
      $data['firstNameError'] = 'Please type in your first name.';
    }
    if(empty($data['lastName'])){
      $data['lastNameError'] = 'Please type in your last name.';
    }
    if(empty($data['email'])){
      $data['emailError'] = 'Please type in your email address.';
    }
    if(empty($data['password'])){
      $data['passwordError'] = 'Please choose a password.';
    }
    if(empty($data['confirmedPassword'])){
      $data['confirmedPasswordError'] = 'Please confirm your password.';
    }
  }

  public function createUserSession($user){

  }

  public function logout(){
    
  }
}