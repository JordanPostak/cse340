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

// Get vehicles by classificationId 
function getInventoryByClassification($classificationId){ 
    $db = phpmotorsConnect(); 
    $sql = ' SELECT * FROM inventory WHERE classificationId = :classificationId'; 
    $stmt = $db->prepare($sql); 
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT); 
    $stmt->execute(); 
    $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    $stmt->closeCursor(); 
    return $inventory; 
   }

   // Get vehicle information by invId
function getInvItemInfo($invId){
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM inventory WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $invInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $invInfo;
   }

// Update a vehicle
function updateVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId, $invId) {
    $db = phpmotorsConnect();
    $sql = 'UPDATE inventory SET invMake = :invMake, invModel = :invModel, invDescription = :invDescription, invImage = :invImage, invThumbnail = :invThumbnail, invPrice = :invPrice, invStock = :invStock, invColor = :invColor, classificationId = :classificationId WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invMake', $invMake, PDO::PARAM_STR);
    $stmt->bindValue(':invModel', $invModel, PDO::PARAM_STR);
    $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
    $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
    $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
    $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_STR);
    $stmt->bindValue(':invStock', $invStock, PDO::PARAM_INT);
    $stmt->bindValue(':invColor', $invColor, PDO::PARAM_STR);
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
  }

  function deleteVehicle($invId) {
    $db = phpmotorsConnect();
    $sql = 'DELETE FROM inventory WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
   }

// function to get a list of vehicles based on the classification
   function getVehiclesByClassification($classificationName){
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM inventory WHERE classificationId IN (SELECT classificationId FROM carclassification WHERE classificationName = :classificationName)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);
    $stmt->execute();
    $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $vehicles;
   }

   // Get information for all vehicles
   function getVehicles(){
       $db = phpmotorsConnect();
       $sql = 'SELECT invId, invMake, invModel FROM inventory';
       $stmt = $db->prepare($sql);
       $stmt->execute();
       $invInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
       $stmt->closeCursor();
       return $invInfo;
   }