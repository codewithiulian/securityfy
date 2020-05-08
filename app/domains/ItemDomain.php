<?php

/**
 * This class is the item domain layer.
 * The ItemDomain sits in between the controller and model.
 * It encapsulates and computes items specific business logic.
 */
class ItemDomain extends Controller
{

  public function __construct()
  {
    $this->itemModel = $this->model('Item');
  }

  /**
   * Method to return a count of items.
   */
  public function getUserItemsCounts()
  {
    return $this->itemModel->getUserItemsCounts();
  }

  /**
   * Method that returns an item pertaining to the
   * authenticated user.
   */
  public function getItem($itemId)
  {
    return $this->itemModel->getItem($itemId);
  }

  /**
   * Gets a list of all the items for all users.
   */
  public function getItems()
  {
    return $this->itemModel->getItems();
  }

  /**
   * Method that returns a list of items pertaining to the
   * authenticated user.
   */
  public function getUserItems()
  {
    return $this->itemModel->getUserItems();
  }

  /**
   * Defines the default data for the request.
   */
  public function defineRequestData($postData)
  {
    $imageError = '';
    // Define default data object.
    $data = [
      'title' => trim($postData['title']),
      'type' => trim($postData['type']),
      'description' => trim($postData['description']),
      'image' => $this->extractImage($imageError),
      'titleError' => '',
      'descriptionError' => '',
      'imageError' => $imageError
    ];

    return $data;
  }

  /**
   * Validates for empty fields.
   */
  public function validateEmptyFields(&$data)
  {
    if (empty($data['title'])) {
      $data['titleError'] = 'Please fill in the title of the item.';
    }
    if (empty($data['description'])) {
      $data['descriptionError'] = 'Please give your item a description.';
    }
  }

  /**
   * Function that returns true if all errors are empty.
   */
  public function fieldsAreValid($data)
  {
    return empty($data['titleError'])
      && empty($data['descriptionError'])
      && empty($data['imageError']);
  }

  /**
   * Function to add an item to the database for a user.
   */
  public function addItem($data)
  {
    return $this->itemModel->addItem($data);
  }

  /**
   * Helper function to define a default object to load the view with.
   */
  public function defineInitData()
  {
    // Define default data object.
    $data = [
      'title' => '',
      'type' => '',
      'description' => '',
      'image' => '',
      'titleError' => '',
      'descriptionError' => '',
      'imageError' => ''
    ];

    return $data;
  }

  /**
   * Method that extracts the image from the form input.
   * It also catches errors, limits file sizes and types.
   */
  private function extractImage(&$imageError)
  {

    // Docs reference: https://www.php.net/manual/en/features.file-upload.php
    $imageFile = $_FILES['image'];

    // Get the file properties.
    $fileName = $_FILES['image']['name'];
    $fileType = $_FILES['image']['type'];
    $fileLocation = $_FILES['image']['tmp_name'];
    $fileError = $_FILES['image']['error'];
    $fileSize = $_FILES['image']['size'];

    // Get the file type from name (lower case).
    $fileExtRaw = explode('.', $fileName);
    $fileExt = strtolower(end($fileExtRaw));
    // Define the allowed extensions.
    $allowedExt = array('png', 'jpeg', 'jpg');

    if ($fileError == UPLOAD_ERR_NO_FILE) {
      $imageError = "Please don't forget to upload an image with your item.";
      return null;
    } else if (in_array($fileExt, $allowedExt)) {
      // If there's any error uploading the file.
      if ($fileError === 0) {
        // Max file size is 10Mb.
        if ($fileSize < 10000000) {
          return $fileLocation;
          // $fileCurrentName = uniqid('', true) . "" .$fileExt;
          // $fileDest = 'uploads' . $fileCurrentName;
          // move_uploaded_file($fileLocation, $fileDest);
        } else {
          $imageError = 'The file uploaded is too large (max 10 Mb).';
          return null;
        }
      } else {
        $imageError = 'There was an error uploading your file.';
        return null;
      }
    } else {
      $imageError = 'File type not supported (PNG, JPEG and JPG).';
      return null;
    }

    return $fileLocation;
  }
}
