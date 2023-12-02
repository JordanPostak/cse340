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
        $searchQuery = filter_input(INPUT_POST, 'searchQuery', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // Get the current page from the URL or set it to 1 by default
        $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

        var_dump($currentPage);

        // Create a connection object from the phpmotors connection function
        $db = phpmotorsConnect();

        // Count the total number of records
        $totalRecords = countTotalSearchResults($searchQuery);

        // Calculate the total number of pages
        $recordsPerPage = 5;
        $totalPages = ceil($totalRecords / $recordsPerPage);

        // Calculate the starting record for the current page
        $startRecord = ($currentPage - 1) * $recordsPerPage;

        // SQL query to perform a search using the indexes with LIMIT
        $sql = "SELECT i.*, img.imgPath, img.imgPrimary
                FROM inventory i
                LEFT JOIN images img ON i.invId = img.invId
                WHERE 
                    (i.invMake LIKE :searchQuery 
                    OR i.invModel LIKE :searchQuery 
                    OR i.invDescription LIKE :searchQuery 
                    OR i.invColor LIKE :searchQuery 
                    OR i.invYear LIKE :searchQuery)
                    AND img.imgName LIKE :thumbnailPattern
                    AND img.imgPrimary = 1
                LIMIT :startRecord, :recordsPerPage";

        // Create a prepared statement
        $stmt = $db->prepare($sql);

        // Bind the parameter values
        $stmt->bindValue(':searchQuery', '%' . $searchQuery . '%', PDO::PARAM_STR);
        $stmt->bindValue(':thumbnailPattern', '%-tn%', PDO::PARAM_STR);
        $stmt->bindValue(':startRecord', $startRecord, PDO::PARAM_INT);
        $stmt->bindValue(':recordsPerPage', $recordsPerPage, PDO::PARAM_INT);

        // Execute the prepared statement
        $stmt->execute();

        // Fetch the search results
        $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Close the cursor
        $stmt->closeCursor();

        // Display the search form which includes the results and pagination
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/search-form.php';
        exit(); // Stop further execution after sending the response
        break;

    default:
        // Display the default search form
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/search-form.php';
        break;
}
?>