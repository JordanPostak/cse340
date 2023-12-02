<?php
// model/search-model.php


function countTotalSearchResults($searchQuery) {
    // Create a connection object from the phpmotors connection function
    $db = phpmotorsConnect();

    // Count the total number of records
    $countSql = "SELECT COUNT(*) AS total FROM inventory i
                 LEFT JOIN images img ON i.invId = img.invId
                 WHERE 
                    (i.invMake LIKE :searchQuery 
                    OR i.invModel LIKE :searchQuery 
                    OR i.invDescription LIKE :searchQuery 
                    OR i.invColor LIKE :searchQuery 
                    OR i.invYear LIKE :searchQuery)
                    AND img.imgName LIKE :thumbnailPattern
                    AND img.imgPrimary = 1";

    $countStmt = $db->prepare($countSql);
    $countStmt->bindValue(':searchQuery', '%' . $searchQuery . '%', PDO::PARAM_STR);
    $countStmt->bindValue(':thumbnailPattern', '%-tn%', PDO::PARAM_STR);
    $countStmt->execute();

    $totalRecords = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Close the cursor
    $countStmt->closeCursor();

    // Set totalRecords in session
    $_SESSION['totalRecords'] = $totalRecords;

    return $totalRecords;
}
?>