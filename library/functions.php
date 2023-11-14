<?php
/*
* Library of custom functions
 */

function checkEmail($clientEmail){
 $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
 return $valEmail;
}

// Check the password for a minimum of 8 characters,
 // at least one 1 capital letter, at least 1 number and
 // at least 1 special character
function checkPassword($clientPassword){
   $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]\s])(?=.*[A-Z])(?=.*[a-z])(?:.{8,})$/';
   return preg_match($pattern, $clientPassword);
}

// Function to build a navigation bar using classifications
function buildNavigation($classifications) {
   $navList = '<ul>';
   $navList .= "<li><a href='/phpmotors/' title='View the PHP Motors home page'>Home</a></li>";
   foreach ($classifications as $classification) {
       $navList .= "<li><a href='/phpmotors/vehicles/?action=classification&classificationName=" . urlencode($classification['classificationName']) . "' title='View our $classification[classificationName] lineup of vehicles'>$classification[classificationName]</a></li>";
   }
   $navList .= '</ul>';

   return $navList;
}

// Build the classifications select list 
function buildClassificationList($classifications){ 
   $classificationList = '<select name="classificationId" id="classificationList">'; 
   $classificationList .= "<option>Choose a Classification</option>"; 
   foreach ($classifications as $classification) { 
    $classificationList .= "<option value='$classification[classificationId]'>$classification[classificationName]</option>"; 
   } 
   $classificationList .= '</select>'; 
   return $classificationList; 
  }

// function to build a display of vehicles within an unordered list
function buildVehiclesDisplay($vehicles){
   $baseURL = '/phpmotors';  // Adjust this based on your project structure
   $dv = '<ul id="inv-display">';
   foreach ($vehicles as $vehicle) {
       $thumbnailPath = $baseURL . $vehicle['invThumbnail'];
       $dv .= '<li>';
       $dv .= "<img src='$thumbnailPath' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'>";
       $dv .= '<hr>';
       $dv .= "<h2>$vehicle[invMake] $vehicle[invModel]</h2>";
       $dv .= "<span>$vehicle[invPrice]</span>";
       $dv .= '</li>';
   }
   $dv .= '</ul>';
   return $dv;
}