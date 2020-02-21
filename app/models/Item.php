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
   * Returns a list of products pertaining to a user id.
   */
  public function getItems($userId){
    $this->db->query('SELECT items.item_name AS itemTitle,
                             items.item_description AS itemDescription
                      FROM items WHERE items.user_id = :userId');
    $this->db->addParameter(':userId', $userId);

    return $this->db->getList();
  }
}