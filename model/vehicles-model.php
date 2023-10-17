<?php

/*
* Vehicles Model
*/

//function for inserting a new classification to the carclassification table.
function insertClassification($classificationName) {
    // Create a connection object from the phpmotors connection function
    $db = phpmotorsConnect();
    
    // SQL query to insert a new classification
    $sql = 'INSERT INTO carclassification (classificationName) VALUES (:classificationName)';
    
    // Create a prepared statement
    $stmt = $db->prepare($sql);
    
    // Bind the parameter values
    $stmt->bindValue(':classificationName', $classificationName);
    
    // Execute the prepared statement
    $stmt->execute();
    
    // Check if the insertion was successful
    if ($stmt->rowCount() > 0) {
        return true; // Return true to indicate success
    } else {
        return false; // Return false to indicate failure
    }
}


// Function for inserting a new vehicle into the inventory table.
function insertVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId) {
    // Create a connection object from the phpmotors connection function
    $db = phpmotorsConnect();
    
    // SQL query to insert a new vehicle
    $sql = 'INSERT INTO inventory (invMake, invModel, invDescription, invImage, invThumbnail, invPrice, invStock, invColor, classificationId) 
            VALUES (:make, :model, :description, :image, :thumbnail, :price, :stock, :color, :classificationId)';
    
    // Create a prepared statement
    $stmt = $db->prepare($sql);
    
    // Bind the parameter values
    $stmt->bindValue(':make', $invMake);
    $stmt->bindValue(':model', $invModel);
    $stmt->bindValue(':description', $invDescription);
    $stmt->bindValue(':image', $invImage);
    $stmt->bindValue(':thumbnail', $invThumbnail);
    $stmt->bindValue(':price', $invPrice);
    $stmt->bindValue(':stock', $invStock);
    $stmt->bindValue(':color', $invColor);
    $stmt->bindValue(':classificationId', $classificationId);
    
    // Execute the prepared statement
    $stmt->execute();
    
    // Check if the insertion was successful
    if ($stmt->rowCount() > 0) {
        return true; // Return true to indicate success
    } else {
        return false; // Return false to indicate failure
    }
}
