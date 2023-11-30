<?php

// Check if the client is logged in and has a clientLevel greater than 1
if (!isset($_SESSION['loggedin']) || $_SESSION['clientData']['clientLevel'] <= 1) {
    header("Location: /phpmotors/");
    exit;
}

// Store the dropdown selection code in a variable
$classificationList = '<select name="classificationId" id="classificationList">';
$classificationList .= "<option>Choose a Classification</option>";
foreach ($classifications as $classification) {
    $selected = '';
    if (isset($classificationId) && $classification['classificationId'] == (int)$classificationId) {
        $selected = 'selected';
    } elseif (isset($invInfo['classificationId']) && $classification['classificationId'] == $invInfo['classificationId']) {
        $selected = 'selected';
    }
    $classificationList .= "<option value='{$classification['classificationId']}' $selected>{$classification['classificationName']}</option>";
}
$classificationList .= '</select>';
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/base.css?v=<?php echo time(); ?>">
    <link rel="icon" type="image/ico" href="images/site/logo.png">

    <title><?php if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
		echo "Modify $invInfo[invMake] $invInfo[invModel]";} 
	    elseif(isset($invMake) && isset($invModel)) { 
		echo "Modify $invMake $invModel"; }?></title>
        
</head>
<body>
    <div class=border>
        <header>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
        </header>
        <nav>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/navigation.php'; ?>
        </nav>
        <main>
            <h1><?php if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
            echo "Modify $invInfo[invMake] $invInfo[invModel]";} 
            elseif(isset($invMake) && isset($invModel)) { 
            echo "Modify$invMake $invModel"; }?></h1>
            
            <div class="message-container">
                <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>
            </div>
            
            <!-- Modify Vehicle Form -->
            <form action="/phpmotors/vehicles/index.php" method="post">
                <input type="hidden" name="action" value="updateVehicle">

                <?php
                // Retrieve the $classificationId for the vehicle being edited (e.g., from the database or existing vehicle data)
                $classificationId = $invInfo['classificationId'];
                ?>


                <!-- Dropdown for classificationId (Populate this dropdown from the controller) -->
                <label for="classificationId">Classification:</label>
                <select name="classificationId" id="classificationId">
                    <option value="" disabled selected>Choose car classification</option>
                    <?php
                    foreach ($classifications as $classification) {
                        $selected = ($classification['classificationId'] == $classificationId) ? 'selected' : '';
                        echo "<option value='{$classification['classificationId']}' $selected>{$classification['classificationName']}</option>";
                    }
                    ?>
                </select>

                <!-- Add form fields for vehicle details -->
                <label for="invMake">Make:</label>
                <input type="text" name="invMake" id="invMake" required <?php if(isset($invMake)){ echo "value='$invMake'"; } elseif(isset($invInfo['invMake'])) {echo "value='$invInfo[invMake]'"; }?>>

                <label for="invModel">Model:</label>
                <input type="text" name="invModel" id="invModel" required <?php if(isset($invModel)){ echo "value='$invModel'"; } elseif(isset($invInfo['invModel'])) {echo "value='$invInfo[invModel]'"; }?>>

                <label for="invImage">Description:</label>
                <textarea name="invDescription" id="invDescription" required><?php if(isset($invDescription)){ echo $invDescription; } elseif(isset($invInfo['invDescription'])) {echo $invInfo['invDescription']; }?></textarea>

                <label for="invMiles">Miles:</label>
                <input type="text" name="invMiles" id="invMiles" placeholder="Miles" required <?php if(isset($invMiles)){echo "value='$invMiles'";} elseif(isset($invInfo['invMiles'])) {echo "value='$invInfo[invMiles]'"; } ?>>

                <label for="invYear">Year:</label>
                <input type="text" name="invYear" id="invYear" placeholder="Year" required <?php if(isset($invYear)){echo "value='$invYear'";} elseif(isset($invInfo['invYear'])) {echo "value='$invInfo[invYear]'"; } ?>>

                <label for="invPrice">Price:</label>
                <input type="number" name="invPrice" id="invPrice" placeholder="Price" step="0.01" required <?php if(isset($invPrice)){echo "value='$invPrice'";} elseif(isset($invInfo['invPrice'])) {echo "value='$invInfo[invPrice]'"; } ?>>

                <label for="invStock">Stock:</label>
                <input type="number" name="invStock" id="invStock" placeholder="Stock" required <?php if(isset($invStock)){echo "value='$invStock'";} elseif(isset($invInfo['invStock'])) {echo "value='$invInfo[invStock]'"; } ?>>

                <label for="invColor">Color:</label>
                <input type="text" name="invColor" id="invColor" placeholder="Color" required <?php if(isset($invColor)){echo "value='$invColor'";} elseif(isset($invInfo['invColor'])) {echo "value='$invInfo[invColor]'"; } ?>>

                <button type="submit" name="submit">Update Vehicle</button>
                <input type="hidden" name="action" value="updateVehicle">
                <input type="hidden" name="invId" value="
                <?php if(isset($invInfo['invId'])){ echo $invInfo['invId'];} 
                elseif(isset($invId)){ echo $invId; } ?>
                ">
            </form>
        </main>
        <footer>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
        </footer>
        <script src="/phpmotors/scripts/last_updated.js"></script>
    </div>
</body>
</html>