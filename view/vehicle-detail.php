<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/base.css?v=<?php echo time(); ?>">
    <link rel="icon" type="image/ico" href="images/site/logo.png">
    <title><?php 
    if (isset($vehicleInfo['invMake']) && isset($vehicleInfo['invModel'])) { 
        echo "$vehicleInfo[invMake] $vehicleInfo[invModel] Details"; 
    } elseif (isset($invMake) && isset($invModel)) { 
        echo "$invMake $invModel Detail"; 
    }
    ?></title>
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
    <h1><?php 
        if (isset($vehicleInfo['invMake']) && isset($vehicleInfo['invModel'])) { 
            echo "$vehicleInfo[invMake] $vehicleInfo[invModel]"; 
        } elseif (isset($invMake) && isset($invModel)) { 
            echo "$invMake $invModel Detail"; 
        }
    ?></h1>

    <div class="message-container">
        <?php
        if (isset($message)) {
            echo $message;
        }
        ?>
    </div>

    <div class="vehicle-details">
        <?php
        // Call the buildVehicleDetail function to get HTML for displaying detailed information
        echo buildVehicleDetail($vehicleInfo, $thumbnails);
        ?>

        <!-- Move the closing div tag for vehicle-details here -->
    </div>

</main>
        <footer>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
        </footer>
        <script src="/phpmotors/scripts/last_updated.js"></script>
    </div>
</body>
</html>