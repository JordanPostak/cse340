<?php
// This is the Accounts controller

// Create or access a Session
session_start();

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
// Get the acconts model for use as needed
require_once '../model/accounts-model.php';
// Get the functions library
require_once '../library/functions.php';

// Get the array of classifications
$classifications = getClassifications();

// Build a navigation bar using the $classifications array
$navList = buildNavigation($classifications);

// Check if the firstname cookie exists, get its value
if(isset($_COOKIE['firstname'])){
  $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
 }

$action = filter_input(INPUT_POST, 'action');
 if ($action == NULL){
  $action = filter_input(INPUT_GET, 'action');
 }

// Switch Statement
switch ($action) {
    // Code to deliver the views will be here

  case 'register':
    // Filter and store the data
      $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
      $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
      $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
      $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

      $clientEmail = checkEmail($clientEmail);
      $checkPassword = checkPassword($clientPassword);

      // check for existing email
      $existingEmail = checkExistingEmail($clientEmail);

      // Deal with existing email during registration
      if($existingEmail){
        $_SESSION['message'] = '<p class="center red">The email address already exists. Do you want to login instead?</p>';
        include '../view/login.php';
        exit;
      }

    // Check for missing data
    if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)){
      $_SESSION['message'] = '<p class="center red">Please provide information for all empty form fields.</p>';
      include '../view/registration.php';
      exit;
    }
    
    // Hash the checked password
    $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

    // Send the data to the model
    $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);
    
    // Check and report the result
    if($regOutcome === 1){
      setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
      $_SESSION['message'] = '<p class="center red">Thanks for registering $clientFirstname. Please use your email and password to login.</p>';
      header('Location: /phpmotors/accounts/?action=loginview');
      exit;
    } else {
      $_SESSION['message'] = '<p class="center red">Sorry $clientFirstname, but the registration failed. Please try again.</p>';
      include '../view/registration.php';
      exit;
    }
        break;



  case 'Login':
    // Filter and store the data
    $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
    $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $clientEmail = checkEmail($clientEmail);
    $checkPassword = checkPassword($clientPassword);

    // Check for missing data
    if (empty($clientEmail) || empty($clientPassword)) {
      $_SESSION['message'] = '<p class="center red">Please provide information for all empty form fields.</p>';
        include '../view/login.php';
    } else {
        // The Login info was incorrect; 
        $_SESSION['message'] = '<p class="center red">Please check your password and try again.</p>';
        include '../view/login.php';
    }

    // A valid password exists, proceed with the login proces. Query the client data based on the email address
    $clientData = getClient($clientEmail);
    // Compare the password just submitted against the hashed password for the matching client
    $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
    //If the hashes don't match create an error and return to the login view
    if (!$hashCheck) {
      $message = '<p class="center red">Please check your password and try again.</p>';
      include '../view/login.php';
      exit;
    }
    // A valid user exists, log them in
    $_SESSION['loggedin'] = TRUE;
    //Remove the password from the array
    array_pop($clientData);
    //Store the array into the session
    $_SESSION['clientData'] = $clientData;

    // Set a success message
    $_SESSION['message'] = '<p class="center red">You are logged in.</p>';

    // Send them to the default view (admin.php)
    header('Location: /phpmotors/accounts/');
    exit;
    break;

  case 'logout':
    // Log the user out
    $_SESSION = array(); // Clear all session data
    session_destroy(); // Destroy the session
    header("Location: /phpmotors/"); // Redirect to the home page or another desired location
    exit;
    break;

  case 'loginview':
    include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/login.php';
    break;

  case 'registrationview':
    include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/registration.php';
    break;

  case 'update':
    // Include the view for updating account information
    include '../view/client-update.php';
    exit;
    break;

  case 'updateAccount':
  
    // Filter and collect the inputs
    $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
    $clientId = trim(filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT));
  
    // Validate and check for errors
    if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail)) {
      $message = '<p class="center red">Please provide information for all empty form fields.</p>';
      include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/client-update.php';
      exit;
    }
  
    // Check if the email address is different from the one in the session
    if ($clientEmail !== $_SESSION['clientData']['clientEmail']) {
      // Check if the new email address already exists in the clients table
      $existingEmail = checkExistingEmail($clientEmail);
  
      if ($existingEmail) {
        $message = '<p class="center red">The email address already exists. Please choose a different email address.</p>';
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/client-update.php';
        exit;
      }
    }
  
    // Process the update using an appropriate function
    $updateResult = updateClient($clientFirstname, $clientLastname, $clientEmail, $clientId);
  
    // Set a success or failure message and store it in the session
    if ($updateResult) {
      $_SESSION['message'] = '<p class="center red">Your account information has been updated.</p>';
    } else {
      $_SESSION['message'] = '<p class="center red">Sorry, the update failed. Please try again.</p>';
    }
  
    // Query the client data from the database, based on the clientId
    $clientData = getClientById($clientId);
  
    // Store the new client data into the session
    $_SESSION['clientData'] = $clientData;
  
    // Deliver the "client-update.php" view with success or failure message
    header('Location: /phpmotors/accounts/?action=clientupdate');
    exit;
  
    break;
  
  case 'updatePassword':

    // Filter and collect the new password
    $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $clientId = trim(filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT));

    // Validate the new password
    $checkPassword = checkPassword($clientPassword);

    if ($checkPassword === 0) {
      $message = '<p class="center red">Invalid password format. Password must meet the requirements.</p>';
      $_SESSION['message'] = $message;
      header('Location: /phpmotors/accounts/?action=update');
      exit;
  }

    // Debugging: Print the values
    var_dump($message);

    // Hash the new password
    $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

    var_dump($hashedPassword);

    // Update the password in the database
    $updateResult = updatePassword($hashedPassword, $clientId);

    var_dump($updateResult);

    // Set a success or failure message and store it in the session
    if ($updateResult) {
        $_SESSION['message'] = '<p class="center red">Your password has been updated.</p>';
    } else {
        $_SESSION['message'] = '<p class="center red">Sorry, the password update failed. Please try again.</p>';
    }

    // Deliver the "password-update-result.php" view
    header('Location: /phpmotors/accounts/?action=passwordupdateresult');
    exit;

    break;

  default:
    include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/admin.php';
    break;
}

?>