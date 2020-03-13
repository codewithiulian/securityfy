<?php

class User {
  private $db;

  public function __construct(){
    $this->db = new Database();
  }

  public function register($data){
     $this->db->query('INSERT INTO users
                                  (first_name,
                                  last_name,
                                  email,
                                  password)
                       VALUES     (:firstName,
                                   :lastName,
                                   :email,
                                   :password)');
    $this->db->addParameter(':firstName', $data['firstName']);
    $this->db->addParameter(':lastName', $data['lastName']);
    $this->db->addParameter(':email', $data['email']);
    $this->db->addParameter(':password', $data['password']);

    return $this->db->execute();
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

    $result = $this->db->getSingle();

    return $this->db->rowCount() > 0;
  }
}