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
    $selected = (isset($classificationId) && $classification['classificationId'] == (int)$classificationId) ? 'selected' : '';
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
    <title>Add Vehicle</title>
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
            <h1>Add Vehicle</h1>
            
            <div class="message-container">
                <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>
            </div>
            
            <!-- Add Vehicle Form -->
            <form action="/phpmotors/vehicles/index.php" method="post">
                <input type="hidden" name="action" value="add-vehicle">
                <!-- Dropdown for classificationId (Populate this dropdown from the controller) -->
                <label for="classificationId">Classification:</label>
                <select name="classificationId" id="classificationId">
                    <option value="" disabled selected>Choose car classification</option>
                    <?php
                    foreach ($classifications as $classification) {
                        $selected = ($classification['classificationId'] == $classificationId) ? 'selected' : '';
                        echo '<option value="' . $classification['classificationId'] . '" ' . $selected . '>' . $classification['classificationName'] . '</option>';
                    }
                    ?>
                </select>

                <!-- Add form fields for vehicle details -->
                <label for="invMake">Make:</label>
                <input type="text" name="invMake" id="invMake" placeholder="Make" <?php if(isset($invMake)){echo "value='$invMake'";}  ?> required>

                <label for="invModel">Model:</label>
                <input type="text" name="invModel" id="invModel" placeholder="Model" <?php if(isset($invModel)){echo "value='$invModel'";}  ?> required>

                <label for="invDescription">Description:</label>
                <textarea name="invDescription" id="invDescription" placeholder="Description" <?php if(isset($invDescription)){echo "value='$invDescription'";}  ?> required></textarea>

                <label for="invImage">Image Path:</label>
                <input type="text" name="invImage" id="invImage" placeholder="Image Path" value="/phpmotors/images/no-image/no-image.png" <?php if(isset($invImage)){echo "value='$invImage'";}  ?> required>

                <label for="invThumbnail">Thumbnail Path:</label>
                <input type="text" name="invThumbnail" id="invThumbnail" placeholder="Thumbnail Path" value="/phpmotors/images/no-image/no-image.png" <?php if(isset($invThumbnail)){echo "value='$invThumbnail'";}  ?> required>

                <label for="invPrice">Price:</label>
                <input type="number" name="invPrice" id="invPrice" placeholder="Price" step="0.01" <?php if(isset($invPrice)){echo "value='$invPrice'";}  ?> required>

                <label for="invStock">Stock:</label>
                <input type="number" name="invStock" id="invStock" placeholder="Stock" <?php if(isset($invStock)){echo "value='$invStock'";}  ?> required>

                <label for="invColor">Color:</label>
                <input type="text" name="invColor" id="invColor" placeholder="Color" <?php if(isset($invColor)){echo "value='$invColor'";}  ?> required>

                <button type="submit">Add Vehicle</button>
            </form>
        </main>
        <footer>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
        </footer>
        <script src="/phpmotors/scripts/last_updated.js"></script>
    </div>
</body>
</html>