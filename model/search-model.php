<?php
// model/search-model.php
function searchResults($searchQuery) {
     // Create a connection object from the phpmotors connection function
     $db = phpmotorsConnect();

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
                 AND img.imgPrimary = 1";

     // Create a prepared statement
     $stmt = $db->prepare($sql);

     // Bind the parameter values
     $stmt->bindValue(':searchQuery', '%' . $searchQuery . '%', PDO::PARAM_STR);
     $stmt->bindValue(':thumbnailPattern', '%-tn%', PDO::PARAM_STR);

     // Execute the prepared statement
     $stmt->execute();

     // Fetch the search results
     $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

     return $searchResults;

}

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

   

    return $totalRecords;
}
?>