<?php

// Check if the client is logged in and has a clientLevel greater than 1
if (!isset($_SESSION['loggedin']) || $_SESSION['clientData']['clientLevel'] <= 1) {
    header("Location: /phpmotors/");
    exit;
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/base.css?v=<?php echo time(); ?>">
    <link rel="icon" type="image/ico" href="images/site/logo.png">

    <title><?php if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
		echo "Delete $invInfo[invMake] $invInfo[invModel]";} 
	    elseif(isset($invMake) && isset($invModel)) { 
		echo "Delete $invMake $invModel"; }?></title>
        
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
            echo "Delete $invInfo[invMake] $invInfo[invModel]";} 
            elseif(isset($invMake) && isset($invModel)) { 
            echo "Delete $invMake $invModel"; }?></h1>
            
            <div class="message-container">
                <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>
            </div>
            <p class="center red">Confirm Vehicle Deletion. The delete is permanent!</p>
            <!-- Modify Vehicle Form -->
            <form action="/phpmotors/vehicles/index.php" method="post">

                <!-- Add form fields for vehicle details -->
                <label for="invMake">Make:</label>
                <input type="text" name="invMake" id="invMake" readonly <?php if(isset($invMake)){ echo "value='$invMake'"; } elseif(isset($invInfo['invMake'])) {echo "value='$invInfo[invMake]'"; }?>>

                <label for="invModel">Model:</label>
                <input type="text" name="invModel" id="invModel" readonly <?php if(isset($invModel)){ echo "value='$invModel'"; } elseif(isset($invInfo['invModel'])) {echo "value='$invInfo[invModel]'"; }?>>

                <textarea name="invDescription" id="invDescription" readonly><?php if(isset($invDescription)){ echo $invDescription; } elseif(isset($invInfo['invDescription'])) {echo $invInfo['invDescription']; }?></textarea>
                
                <button type="submit" name="submit">Delete Vehicle</button>
                <input type="hidden" name="action" value="deleteVehicle">
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