<?php

class Pages extends Controller
{

  public function __construct()
  {
    $this->userModel = $this->model('User');
    $this->itemDomain = $this->domain('ItemDomain');
  }

  // Functionality for the Dashboard page
  public function dashboard()
  {
    // Redirect if not logged in.
    if (!isLoggedIn()) redirect('pages/index');

    // If the request is a GET.
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      // Get the dashboard data.
      $data = $this->populateDashboard();

      // If the 
      if (isset($_GET['request'])) {
        if ($_GET['request'] === "dashboard_request_data") {
          echo json_encode($data);
        }
      } else {
        // Load the dashboard.
        $this->view('pages/dashboard', $data);
      }
    }
  }

  public function add()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      // Initialise the data object array.
      $data = $this->itemDomain->defineRequestData($_POST);

      // Empty fields validation.
      $this->itemDomain->validateEmptyFields($data);

      // If all the fields are valid.
      if ($this->itemDomain->fieldsAreValid($data)) {
        // Add the item and redirect to dashboard.
        if ($this->itemDomain->addItem($data)) {
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
      $data = $this->itemDomain->defineInitData();
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

  /**
   * Binds the data necessary for the dashboard.
   */
  private function populateDashboard()
  {
    // Get items counts data for the Insights section.
    $insights = $this->itemDomain->getUserItemsCounts();
    $items = $this->itemDomain->getUserItems();


    $data = array(
      "totalItems" => $insights->totalItems,
      "totalProducts" => $insights->totalProducts,
      "totalServices" => $insights->totalServices,
      "items" => $items
    );

    return $data;
  }
}
