<?php

class Pages extends Controller
{

  public function __construct()
  {
    $this->userModel = $this->model('User');
    $this->itemModel = $this->model('Item');
  }

  // Functionality for the Dashboard page
  public function dashboard()
  {
    // Redirect if not logged in.
    if (!isLoggedIn()) redirect('pages/index');

    $data = $this->populateDashboard();

    // Load the dashboard.
    $this->view('pages/dashboard', $data);
  }

  public function add()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      // Initialise the data object array.
      $data = $this->defineRequestData($_POST);

      // Empty fields validation.
      $this->validateEmptyFields($data);

      // If all the fields are valid.
      if ($this->fieldsAreValid($data)) {
        // Add the item and redirect to dashboard.
        if ($this->itemModel->addItem($data)) {
          // Redirect to dashboard.
          redirect('pages/dashboard');
        } else {
          $this->view('items/add', $data);
        }
      } else {
        // If the fields are not valid, reload the view.
        $this->view('items/add', $data);
      }
    } else {
      // Redirect if not logged in.
      if (!isLoggedIn()) redirect('pages/index');
      $data = $this->defineInitData();
      // Load the add view.
      $this->view('items/add', $data);
    }
  }

  // Functionality for the Profile page.
  public function profile()
  {
    // Redirect if not logged in.
    if (!isLoggedIn()) redirect('pages/index');

    $data = [
      'firstName' => $_SESSION['firstName'],
      'lastName' => $_SESSION['lastName'],
      'fullName' => $_SESSION['fullName'],
      'email' => $_SESSION['email'],
      'registeredOn' => $_SESSION['registeredOn']
    ];

    // Load the profile view.
    $this->view('pages/profile', $data);
  }

  public function index()
  {
    $this->view('pages/index');
  }

  // Helper methods.

  // Dashboard functions.

  /**
   * Binds the data necessary for the dashboard.
   */
  private function populateDashboard()
  {
    // Get items counts data for the Insights section.
    $insights = $this->itemModel->getUserItemsCounts();
    $items = $this->itemModel->getUserItems();


    $data = array(
      "totalItems" => $insights->totalItems,
      "totalProducts" => $insights->totalProducts,
      "totalServices" => $insights->totalServices,
      "items" => $items
    );

    return $data;
  }

  // Add functions.

  /**
   * Helper function to define a default object to load the view with.
   */
  private function defineInitData()
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
   * Function that returns true if all errors are empty.
   */
  private function fieldsAreValid($data)
  {
    return empty($data['titleError'])
      && empty($data['descriptionError'])
      && empty($data['imageError']);
  }

  /**
   * Validates for empty fields.
   */
  private function validateEmptyFields(&$data)
  {
    if (empty($data['title'])) {
      $data['titleError'] = 'Please fill in the title of the item.';
    }
    if (empty($data['description'])) {
      $data['descriptionError'] = 'Please give your item a description.';
    }
  }

  /**
   * Defines the default data for the request.
   */
  private function defineRequestData($postData)
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
