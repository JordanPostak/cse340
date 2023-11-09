<?php
// This is the vehicles controller

// Create or access a Session
session_start();

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
// Get the vehicles model for use as needed
require_once '../model/vehicles-model.php';
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


// Build the dynamic dropdown select list
// $classificationList = '<select name="classificationId" id="classificationList">';
// $classificationList .= "<option>Choose a Classification</option>";
// foreach ($classifications as $classification) {
//   $classificationList .= "<option value='$classification[classificationId]'";
//   if (isset($classificationId) && $classification['classificationId'] === (int)$classificationId) {
//     $classificationList .= " selected";
//   }
//   $classificationList .= ">$classification[classificationName]</option>";
// }
// $classificationList .= '</select>';

//Switch Statement
switch ($action){
    case 'class':
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/add-classification.php';
        break;

    case 'vehicle':
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/add-vehicle.php';
        break;

    case 'add-classification':
        // Handle adding a new classification
        $classificationName = filter_input(INPUT_POST, 'classificationName');
    
        if (empty($classificationName)) {
            $message = '<p>Please provide a classification name.</p>';
            include '../view/add-classification.php';
            exit;
        }
        
    
        // Attempt to insert the classification
        $success = insertClassification($classificationName);
    
        if ($success) {
            // If insertion is successful, redirect to the vehicle management view
            header('Location: /phpmotors/vehicles/index.php');
            exit;
        } else {
            // If insertion fails, display an error message in the add-classification view
            $message = 'Failed to add the classification. Please try again.';
            include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/add-classification.php';
            exit;
        }
        break;

    case 'add-vehicle':
        // Handle adding a new vehicle
        // Collect and validate data
        $classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_VALIDATE_INT);
        $invMake = filter_input(INPUT_POST, 'invMake');
        $invModel = filter_input(INPUT_POST, 'invModel');
        $invColor = filter_input(INPUT_POST, 'invColor');
        $invDescription = filter_input(INPUT_POST, 'invDescription');
        $invImage = filter_input(INPUT_POST, 'invImage');
        $invThumbnail = filter_input(INPUT_POST, 'invThumbnail');
        $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_VALIDATE_FLOAT);
        $invStock = filter_input(INPUT_POST, 'invStock', FILTER_VALIDATE_INT);

        // Check for missing or invalid data
        if (
            $classificationId === "" || $classificationId === null ||
            empty($invMake) || empty($invModel) || empty($invColor) ||
            empty($invDescription) || empty($invImage) || empty($invThumbnail) ||
            $invPrice === false || $invPrice === null ||
            $invStock === false || $invStock === null
        ) {
            $message = '<p>Please provide valid data for all form fields.</p>';
            include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/add-vehicle.php';
            exit;
        }

        // Attempt to insert the vehicle
        $success = insertVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId);

        if ($success) {
            // If insertion is successful, set a success message
            $message = 'New vehicle added successfully.';
            // Include the "add-vehicle" view to display the success message
            include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/add-vehicle.php';
            exit;
        } else {
            // If insertion fails, display an error message in the "add-vehicle" view
            $message = 'Failed to add the vehicle. Please try again.';
            include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/add-vehicle.php';
            exit;
        }
    break;

    /* Get vehicles by classificationId Used for starting Update & Delete process */ 
    case 'getInventoryItems': 
        // Get the classificationId 
        $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT); 
        // Fetch the vehicles by classificationId from the DB 
        $inventoryArray = getInventoryByClassification($classificationId); 
        // Convert the array to a JSON object and send it back 
        echo json_encode($inventoryArray); 
        break;

    case 'mod':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
        $invInfo = getInvItemInfo($invId);
        if(count($invInfo)<1){
            $message = 'Sorry, no vehicle information could be found.';
        }
        include '../view/vehicle-update.php';
        exit;
        break;

    case 'updateVehicle':
        $classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
        $invColor = filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
        
        if (empty($classificationId) || empty($invMake) || empty($invModel) 
        || empty($invDescription) || empty($invImage) || empty($invThumbnail)
        || empty($invPrice) || empty($invStock) || empty($invColor)) {
        $message = '<p>Please complete all information for the item! Double check the classification of the item.</p>';
            include '../view/vehicle-update.php';
        exit;
    }
    
    $updateResult = updateVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId, $invId);
    if ($updateResult) {
        $message = "<p class='notice'>Congratulations, the $invMake $invModel was successfully updated.</p>";
        $_SESSION['message'] = $message;
        header('location: /phpmotors/vehicles/');
        exit;
    } else {
        $message = "<p class='notice'>Error. the $invMake $invModel was not updated.</p>";
            include '../view/vehicle-update.php';
            exit;
        }
    break;

    case 'del':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
        $invInfo = getInvItemInfo($invId);
        if (count($invInfo) < 1) {
                $message = 'Sorry, no vehicle information could be found.';
            }
            include '../view/vehicle-delete.php';
            exit;
            break;

    case 'deleteVehicle':
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
        
        $deleteResult = deleteVehicle($invId);
        if ($deleteResult) {
            $message = "<p class='notice'>Congratulations the, $invMake $invModel was	successfully deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        } else {
            $message = "<p class='notice'>Error: $invMake $invModel was not
        deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        }
        break;

    default:
        $classificationList = buildClassificationList($classifications);
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/vehicle-management.php';
        break;
}

?>