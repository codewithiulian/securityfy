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

  /**
   * Prepares the query statement for execution.
   */
  public function query($sql){
    $this->stmt = $this->dbh->prepare($sql);
  }

  /**
   * Adds the given parameter to the query statement.
   */
  public function addParameter($param, $value, $type){
    if(is_null($type)){
      // Define parameter type based on the data type.
      switch(true){
        case is_int($value):
          $type = PDO::PARAM_INT;
          break;
        case is_int($value):
          $type = PDO::PARAM_BOOL;
          break;
        case is_null($value):
          $type = PDO::PARAM_NULL;
          break;
        default:
          $type = PDO::PARAM_STR;
      }
    }
    // Bind parameters
    $this->stmt->bindValue($param, $value, $type);
  }

  /**
   * Executes the query statement.
   * Returns true if successful or false if failed.
   */
  public function execute(){
    return $this->stmt->execute();
  }

  /**
   * Returns a single result object based on the query statement executed.
   */
  public function getSingle(){
    $this->execute();

    return $this->stmt->fetch(PDO::FETCH_OBJ);
  }

  /**
   * Returns an array of results as objects based on the query statement executed.
   */
  public function getList(){
    $this->execute();

    return $this->stmt->fetchAll(PDO::FETCH_OBJ);
  }
}