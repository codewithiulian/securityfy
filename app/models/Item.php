<?php

/**
 * This class interacts with the database.
 * Item Model Creates, Reads, Updates and Deletes products data.
 */
class Item
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  /**
   * Returns items counts for the current user:
   * total items, total products, todal services.
   */
  public function getUserItemsCounts()
  {
    // This query uses conditional SUM functions for returning
    // distinct item counts based on the type of item:
    // items.type_id = 1 -- Product
    // items.type_id = 2 -- Service
    $this->db->query('
      SELECT COUNT(i.item_id) AS totalItems,
             SUM(CASE WHEN i.type_id = 1 THEN 1 ELSE 0 END) AS totalProducts,
             SUM(CASE WHEN i.type_id = 2 THEN 1 ELSE 0 END) AS totalServices
      FROM items AS i
      INNER JOIN users AS u
        ON i.user_id = u.user_id
      WHERE i.user_id = :userId
    ');
    $this->db->addParameter(':userId', $_SESSION['userId']);

    return $this->db->getSingle();
  }

  /**
   * Adds an item to the database for a logged in user.
   */
  public function addItem($data)
  {
    $image = fopen($data['image'], 'rb');
    try {
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
    } catch (PDOException $exception) {
      // Do not catch the exeption only return false.
      return false;
    }
    return true;
  }

  /**
   * Returns an item record for the authenticated user.
   */
  public function getUserItem($itemId)
  {
    $this->db->query("SELECT i.item_id AS itemId,
                             i.item_title AS itemTitle,
                             i.item_description AS itemDescription,
                             CONCAT(u.first_name, ' ', u.last_name) AS itemAuthor,
                             i.updated_on AS itemDate,
                             i.image AS itemImage,
                             it.type_name AS itemType
                      FROM items AS i
                      INNER JOIN users u
                        ON u.user_id = i.user_id
                      INNER JOIN item_type it
                        ON i.type_id = it.type_id
                      WHERE i.user_id = :userId
                        AND i.item_id = :itemId
                      ORDER BY i.updated_on DESC
                      LIMIT 1;");

    $this->db->addParameter(':userId', $_SESSION['userId']);
    $this->db->addParameter(':itemId', $itemId);

    return $this->db->getSingle();
  }

  /**
   * Returns a list of products pertaining to a user id.
   */
  public function getUserItems()
  {
    $this->db->query("SELECT i.item_id AS itemId,
                             i.item_title AS itemTitle,
                             i.item_description AS itemDescription,
                             CONCAT(u.first_name, ' ', u.last_name) AS itemAuthor,
                             i.updated_on AS itemDate,
                             it.type_name AS itemType
                      FROM items AS i
                      INNER JOIN users u
                        ON u.user_id = i.user_id
                      INNER JOIN item_type it
                        ON i.type_id = it.type_id
                      WHERE i.user_id = :userId
                      ORDER BY i.updated_on DESC;");
    $this->db->addParameter(':userId', $_SESSION['userId']);

    return $this->db->getList();
  }
}
