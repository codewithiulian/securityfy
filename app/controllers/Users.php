<?php

class Users extends Controller {

  public function __construct(){
    $this->userModel = $this->model('User');
  }

  public function index(){
    echo 'users index';
  }

  public function login(){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); // https://www.php.net/manual/en/function.filter-input-array.php

      // Initialise the data object array.
      $data = $this->defineDataAssocArray($_POST);
      
      // Validate empty login form.
      $this->validateEmptyLoginForm($data);
      
      // // Verify user credentials.
      // $loggedInUser = $this->getUserCredentials($data);
      if($this->loginFormPassedValidation($data)){
        echo 'logged in';
        // Start session.
        // $this->view('users/login', $data);
      }else{
        $this->view('users/login', $data);
      }
    }else{
      // Initialise empty data object array.
      $data = $this->initDataObject(true);
      // Load the register view with the default data.
      $this->view('users/login', $data);
    }
  }

  public function register(){
    // When the form gets POSTed.
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      // Sanitise the fields.
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); // https://www.php.net/manual/en/function.filter-input-array.php
      
      // Initialise the data object array.
      $data = $this->defineDataAssocArray($_POST);

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
      $data = $this->initDataObject(false);
      // Load the register view with the default data.
      $this->view('users/register', $data);
    }
  }

  /**
   * Returns a logged in user credentials object.
   */
  private function getUserCredentials($data){
    return $this->userModel->getUserCredentials($data);
  }

  /**
   * Validates empty login form.
   */
  private function validateEmptyLoginForm(&$data){
    if(empty($data['email'])){
      $data['emailError'] = 'Please fill in your email address.';
    }
    if(empty($data['password'])){
      $data['passwordError'] = 'Please fill in your password.';
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

  private function loginFormPassedValidation($data){
    return empty($data['emailError'])
        && empty($data['passwordError']);
  }

  /**
   * Returns an empty associative array.
   * isLogin is true if initialiser called
   * from the login method.
   */
  private function initDataObject($isLogin){
    $data = [
      'email' => '',
      'password' => '',
      'emailError' => '',
      'passwordError' => ''
    ];

    // If this is the registration initialiser.
    if(!$isLogin){
      // Define all the fields.
      $data += [
        'firstName' => '',
        'lastName' => '',
        'confirmedPassword' => '',
        'firstNameError' => '',
        'lastNameError' => '',
        'confirmedPasswordError' => ''
      ];
    }

    return $data;
  }

  private function defineDataAssocArray($postData){
    // Define default data object.
    $data =  [
      'email' => trim($postData['email']),
      'password' => trim($postData['password']),
      'emailError' => '',
      'passwordError' => ''
    ];

    // If this method is requested on registration.
    if(isset($postData['firstName'])){
      // Add registration indexes to the assoc array.
      $data += [
        'firstName' => trim($postData['firstName']),
        'lastName' => trim($postData['lastName']),
        'confirmedPassword' => trim($postData['confirmedPassword']),
        'firstNameError' => '',
        'lastNameError' => '',
        'confirmedPasswordError' => ''
      ];
    }

    return $data;
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