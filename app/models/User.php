<?php

class User {
  private $db;

  public function __construct(){
    $this->db = new Database();
  }

  /**
   * Returns user object if user credentials are correct.
   */
  public function getUserCredentials($data){
    $this->db->query("SELECT TOP(1)
                             user_id                            AS userId,
                             first_name                         AS firstName,
                             last_name                          AS lastName,
                             CONCAT(first_name, '', last_name)  AS fullName
                      FROM users
                      WHERE email = :email
                        AND password = :password;");
    $this->db->addParameter(':email', $data['email']);
    $this->db->addParameter(':password', $data['password']);

    return $this->db->getSingle();
  }

  /**
   * Register a user.
   * Save first name, last name, email and password
   * into the database.
   */
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