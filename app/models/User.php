<?php

class User {
  private $db;

  public function __construct(){
    $this->db = new Database();
  }

  /**
   * Returns user object if user credentials are correct.
   * No distinction is made between incorrect password and
   * no user found, due to security reasons. Both scenarios
   * return false. A generic error message should be shown.
   */
  public function getUserCredentials($email, $password){
    // Get user by email.
    $this->db->query("SELECT user_id                            AS userId,
                             first_name                         AS firstName,
                             last_name                          AS lastName,
                             CONCAT(first_name, ' ', last_name) AS fullName,
                             email,
                             password,
                             active_on                          AS activeOn,
                             registered_on                      AS registeredOn
                      FROM users
                      WHERE email = :email;");
    $this->db->addParameter(':email', $email);

    $row = $this->db->getSingle();

    // If there is a record returned.
    if($this->db->rowCount() > 0){
      // Hash the password string passed in using the
      // salt and cost provided with the saved hashed password.
      // Please see https://www.php.net/manual/en/function.password-verify.php
      // Verity the password input.
      if (password_verify($password, $row->password)) {
        // If the password is correct return the stdClass user object.
        // Remove the password from the object before passing it to
        // the domain layer (controller) for security purposes.
        unset($row->password);
        return $row;
      }else{
        // Otherwise return false so we can output some errors.
        return false;
      }
    }else{
      // Return false if no record is found.
      return false;
    }
  }

  public function updateUserActivity($userId){
    $this->db->query("UPDATE users
                      SET active_on =	CURRENT_TIMESTAMP()
                      WHERE user_id = :userId;");
    $this->db->addParameter(':userId', $userId);

    $this->db->execute();
  }

  /**
   * Register a user.
   * Save first name, last name, email and password
   * into the database.
   */
  public function register($data){
    // For Guid storage please see: https://mysqlserverteam.com/storing-uuid-values-in-mysql-tables/
    try{
      // Insert the new user record.
      $this->db->query("INSERT INTO users (user_id,
                                           first_name,
                                           last_name,
                                           email,
                                           password)
                        VALUES     (UUID(),
                                    :firstName,
                                    :lastName,
                                    :email,
                                    :password)");
      $this->db->addParameter(':firstName', $data['firstName']);
      $this->db->addParameter(':lastName', $data['lastName']);
      $this->db->addParameter(':email', $data['email']);
      $this->db->addParameter(':password', $data['password']);

      $this->db->execute();
    }catch(PDOException $exception){
      // Do not catch the exeption only return false.
      return false;
    }
    return true;
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