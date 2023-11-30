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
    $dv = '<ul id="inv-display">';
    foreach ($vehicles as $vehicle) {
        $thumbnailPath = $vehicle['imgPath'];
        $vehicleDetailsLink ='/phpmotors/vehicles/?action=getVehicle&invId=' . $vehicle['invId'];

        $dv .= '<li>';
        $dv .= "<a href='$vehicleDetailsLink'>";
        $dv .= "<img src='$thumbnailPath' alt='{$vehicle['invMake']} {$vehicle['invModel']} on phpmotors.com'>";
        $dv .= "<h2>{$vehicle['invMake']} {$vehicle['invModel']}</h2>";
        $dv .= '</a>';
        $dv .= "<p class='price'>Price: $" . number_format($vehicle['invPrice'], 2) . "</p>";
        $dv .= '</li>';
    }
    $dv .= '</ul>';
    return $dv;
}

// function to build HTML for displaying detailed information of a specific vehicle
function buildVehicleDetail($vehicleInfo, $thumbnails = array()){
    $html = '<div class="vehicle-detail">';
    
    // Image div
    $html .= "<div class='image-container'>";
    $html .= "<img src='{$vehicleInfo['invImage']}' alt='{$vehicleInfo['invMake']} {$vehicleInfo['invModel']}'>";
    $html .= "<h2>Additional Images</h2>"; // Title for thumbnails
    $html .= "</div>";
 
    // Thumbnails div with title
    if (!empty($thumbnails)) {
        $html .= '<div class="thumbnails-container">';
        foreach ($thumbnails as $thumbnail) {
            $html .= "<img src='{$thumbnail['imgPath']}' alt='Thumbnail'>";
        }
        $html .= '</div>';
    }
 
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


/* * ********************************
*  Functions for working with images
* ********************************* */

// Adds "-tn" designation to file name
function makeThumbnailName($image) {
   $i = strrpos($image, '.');
   $image_name = substr($image, 0, $i);
   $ext = substr($image, $i);
   $image = $image_name . '-tn' . $ext;
   return $image;
}

// Build images display for image management view
function buildImageDisplay($imageArray) {
   $id = '<ul id="image-display">';
   foreach ($imageArray as $image) {
       $id .= '<li>';
       $id .= "<img src='$image[imgPath]' title='$image[invMake] $image[invModel] image on PHP Motors.com' alt='$image[invMake] $image[invModel] image on PHP Motors.com'>";
        $id .= "<p><a href='/phpmotors/uploads?action=delete&imgId=$image[imgId]&filename=$image[imgName]' title='Delete the image'>Delete $image[imgName]</a></p>";
       $id .= '</li>';
   }
   $id .= '</ul>';
   return $id;
}

// Build the vehicles select list
function buildVehiclesSelect($vehicles) {
   $prodList = '<select name="invId" id="invId">';
   $prodList .= "<option>Choose a Vehicle</option>";
   foreach ($vehicles as $vehicle) {
       $prodList .= "<option value='$vehicle[invId]'>$vehicle[invMake] $vehicle[invModel]</option>";
   }
   $prodList .= '</select>';
   return $prodList;
}

// Handles the file upload process and returns the path
// The file path is stored into the database
function uploadFile($name) {
   global $image_dir, $image_dir_path;
   if (isset($_FILES[$name])) {
       $filename = $_FILES[$name]['name'];
       if (empty($filename)) {
           return;
       }
       $source = $_FILES[$name]['tmp_name'];
       $target = $image_dir_path . '/' . $filename;
       move_uploaded_file($source, $target);
       processImage($image_dir_path, $filename);
       $filepath = $image_dir . '/' . $filename;
       return $filepath;
   }
}

// Processes images by getting paths and creating smaller versions of the image
function processImage($dir, $filename) {
   $dir = $dir . '/';
   $image_path = $dir . $filename;
   $image_path_tn = $dir . makeThumbnailName($filename);
   resizeImage($image_path, $image_path_tn, 200, 200);
   resizeImage($image_path, $image_path, 500, 500);
}

// Checks and Resizes image
function resizeImage($old_image_path, $new_image_path, $max_width, $max_height) {
   $image_info = getimagesize($old_image_path);
   $image_type = $image_info[2];

   switch ($image_type) {
       case IMAGETYPE_JPEG:
           $image_from_file = 'imagecreatefromjpeg';
           $image_to_file = 'imagejpeg';
           break;
       case IMAGETYPE_GIF:
           $image_from_file = 'imagecreatefromgif';
           $image_to_file = 'imagegif';
           break;
       case IMAGETYPE_PNG:
           $image_from_file = 'imagecreatefrompng';
           $image_to_file = 'imagepng';
           break;
       default:
           return;
   }

   $old_image = $image_from_file($old_image_path);
   $old_width = imagesx($old_image);
   $old_height = imagesy($old_image);

   $width_ratio = $old_width / $max_width;
   $height_ratio = $old_height / $max_height;

   if ($width_ratio > 1 || $height_ratio > 1) {
       $ratio = max($width_ratio, $height_ratio);
       $new_height = round($old_height / $ratio);
       $new_width = round($old_width / $ratio);

       $new_image = imagecreatetruecolor($new_width, $new_height);

       if ($image_type == IMAGETYPE_GIF) {
           $alpha = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
           imagecolortransparent($new_image, $alpha);
       }

       if ($image_type == IMAGETYPE_PNG || $image_type == IMAGETYPE_GIF) {
           imagealphablending($new_image, false);
           imagesavealpha($new_image, true);
       }

       $new_x = 0;
       $new_y = 0;
       $old_x = 0;
       $old_y = 0;
       imagecopyresampled($new_image, $old_image, $new_x, $new_y, $old_x, $old_y, $new_width, $new_height, $old_width, $old_height);

       $image_to_file($new_image, $new_image_path);
       imagedestroy($new_image);
   } else {
       $image_to_file($old_image, $new_image_path);
   }

   imagedestroy($old_image);
}
?>