<?php
/**
 * This class interacts with the database.
 * Item Model Creates, Reads, Updates and Deletes products data.
 */
class Item {
  private $db;

  public function __construct() {
    $this->db = new Database();
  }
  
  /**
   * Adds an item to the database for a logged in user.
   */
  public function addItem($data){
    $image = fopen($data['image'], 'rb');
    try{
      // Insert the new user record.
      $this->db->query("INSERT INTO items (item_id,
                                           user_id,
                                           item_title,
                                           item_description,
                                           type_id,
                                           image)
                        VALUES     (UUID(),
                                    :userId,
                                    :itemTitle,
                                    :itemDescription,
                                    :typeId,
                                    :image)");
      $this->db->addParameter(':userId', $_SESSION['userId']);
      $this->db->addParameter(':itemTitle', $data['title']);
      $this->db->addParameter(':itemDescription', $data['description']);
      $this->db->addParameter(':typeId', $data['type']);
      $this->db->addParameter(':image', $image, PDO::PARAM_LOB);

      $this->db->execute();
    }catch(PDOException $exception){
      // Do not catch the exeption only return false.
      return false;
    }
    return true;
  }

  /**
   * Returns a list of products pertaining to a user id.
   */
  public function getItems($userId){
    $this->db->query('SELECT items.item_name AS itemTitle,
                             items.item_description AS itemDescription,
                             users.full_name AS itemAuthor,
                             items.updated_on AS itemDate
                      FROM items
                      INNER JOIN users
                        ON users.user_id = items.user_id
                      WHERE items.user_id = :userId');
    $this->db->addParameter(':userId', $userId);

    return $this->db->getList();
  }
}