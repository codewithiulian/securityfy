<?php

class User {
  private $db;

  public function __construct(){
    $this->db = new Database();
  }

  public function register($data){
    echo 'registered successfuly';
  }

  /**
   * Returns true if a record is found matching on the email.
   */
  public function isEmailInUse($email){
    // Define the query.
    $this->db->query('SELECT user_id
                      FROM users
                      WHERE email = :email;');
    $this->db->addParameter(':email', $email);

    return $this->db->getSingle() > 0;
  }
}