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
   $baseURL = '/phpmotors';
   $dv = '<ul id="inv-display">';
   foreach ($vehicles as $vehicle) {
       $thumbnailPath = $baseURL . $vehicle['invThumbnail'];
       $vehicleDetailsLink = $baseURL . '/vehicles/?action=getVehicle&invId=' . $vehicle['invId'];

       $dv .= '<li>';
       $dv .= "<a href='$vehicleDetailsLink'>";
       $dv .= "<img src='$thumbnailPath' alt='$vehicle[invMake] $vehicle[invModel] on phpmotors.com'>";
       $dv .= "<h2>$vehicle[invMake] $vehicle[invModel]</h2>";
       $dv .= '</a>';
       $dv .= "<p class='price'>Price: $" . number_format($vehicle['invPrice'], 2) . "</p>";
       $dv .= '</li>';
   }
   $dv .= '</ul>';
   return $dv;
}

// function to build HTML for displaying detailed information of a specific vehicle
function buildVehicleDetail($vehicleInfo){
   $html = '<div class="vehicle-detail">';
   
   // Image div
   $html .= "<div class='image-container'>";
   $html .= "<img src='/phpmotors{$vehicleInfo['invImage']}' alt='{$vehicleInfo['invMake']} {$vehicleInfo['invModel']}'>";
   $html .= "</div>";

   // Information div
   $html .= "<div class='info-container'>";
   $html .= "<h2>{$vehicleInfo['invModel']} details:</h2>";
   $html .= "<h2 class='price'>Price: $" . number_format($vehicleInfo['invPrice'], 2) . "</h2>";
   $html .= "<p>{$vehicleInfo['invDescription']}</p>";
   $html .= "<h2><strong>Stock:</strong> {$vehicleInfo['invStock']}</h2>";
   $html .= "<h2><strong>Color:</strong> {$vehicleInfo['invColor']}</h2>";
   $html .= "</div>";

   $html .= '</div>';
   return $html;
}