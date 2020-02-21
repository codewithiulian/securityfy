<?php
/**
 * PDO Database class.
 * Executes DB connections.
 * Binds values and returns the result set.
 * Creates prepared statements.
 */
class Database {
  private $host = DB_HOST;
  private $user = DB_USER;
  private $pass = DB_PASS;
  private $dbname = DB_NAME;

  private $dbh; // Database handler.
  private $stmt; // Query statement.
  private $error; // Error message.

  public function __construct() {
    // Set DSN.
    $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
    // Define the attributes.
    $options = array(
      PDO::ATTR_PERSISTENT => true,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );
    
    // Create PDO instance.
    try{
      $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
    }catch(PDOException $e){
      $this->error = $e->getMessage();
      echo $this->error;
    }
  }
}