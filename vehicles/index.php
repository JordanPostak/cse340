<?php
// This is the vehicles controller

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
// Get the vehicles model for use as needed
require_once '../model/vehicles-model.php';

// Get the array of classifications
$classifications = getClassifications();

//var_dump($classifications);
	//exit;

// Build a navigation bar using the $classifications array
$navList = '<ul>';
$navList .= "<li><a href='/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";
foreach ($classifications as $classification) {
 $navList .= "<li><a href='/phpmotors/index.php?action=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
}
$navList .= '</ul>';

$action = filter_input(INPUT_POST, 'action');
 if ($action == NULL){
  $action = filter_input(INPUT_GET, 'action');
 }


// Build the dynamic dropdown select list
$classificationList = '<select name="classificationId">';
foreach ($classifications as $classification) {
    $classificationId = $classification['classificationId'];
    $classificationName = $classification['classificationName'];
    $classificationList .= "<option value='$classificationId'>$classificationName</option>";
}
$classificationList .= '</select>';

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
        $invDescription = filter_input(INPUT_POST, 'description');
        $invImage = filter_input(INPUT_POST, 'invImage');
        $invThumbnail = filter_input(INPUT_POST, 'invThumbnail');
        $invPrice = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
        $invStock = filter_input(INPUT_POST, 'stock', FILTER_VALIDATE_INT);

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

    default:
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/vehicle-management.php';
        break;
}

?>