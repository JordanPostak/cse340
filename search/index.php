<?php
// This is the vehicles controller

// Create or access a Session
session_start();

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
// Get the search model for use as needed
require_once '../model/search-model.php';
// Get the functions library
require_once '../library/functions.php';
// Get the uploads model for use as needed
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/model/uploads-model.php';

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

// Switch statement for different search actions
switch ($action) {
    case 'performSearch':

        // Process the search query and fetch results
        $searchQuery = filter_input(INPUT_POST, 'searchQuery', FILTER_SANITIZE_EMAIL);
        $_SESSION['searchQuery'] = strip_tags($searchQuery);

         // Check if searchQuery is empty and retrieve it from $_GET if needed
        if (empty($_SESSION['searchQuery']) && isset($_GET['searchQuery'])) {
            $searchQuery = filter_input(INPUT_GET, 'searchQuery', FILTER_SANITIZE_EMAIL);
            $_SESSION['searchQuery'] = strip_tags($searchQuery);
        }

        $searchResults = searchResults($_SESSION['searchQuery']);

        // Get the current page from the URL or set it to 1 by default
        $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

        // Set the results per page
        $resultsPerPage = 5;

        // Get the total number of search results
        $totalRecords = countTotalSearchResults($_SESSION['searchQuery']);

        // Calculate total pages
        $_SESSION['totalPages'] = calculateTotalPages($totalRecords, $resultsPerPage);

        // Display the search results and pagination view
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/search-form.php';
        exit(); // Stop further execution after sending the response
        break;

    default:
        // Display the default search form
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/search-form.php';
        break;
}
?>