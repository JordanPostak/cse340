<!DOCTYPE html>
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
                        echo '<option value="' . $classification['classificationId'] . '">' . $classification['classificationName'] . '</option>';
                    }
                    ?>
                </select>

                <!-- Add form fields for vehicle details -->
                <label for="invMake">Make:</label>
                <input type="text" name="invMake" id="invMake" placeholder="Make">

                <label for="invModel">Model:</label>
                <input type="text" name="invModel" id="invModel" placeholder="Model">

                <label for="description">Description:</label>
                <textarea name="description" id="description" placeholder="Description"></textarea>

                <label for="invImage">Image Path:</label>
                <input type="text" name="invImage" id="invImage" placeholder="Image Path" value="/phpmotors/images/no-image/no-image.png">

                <label for="invThumbnail">Thumbnail Path:</label>
                <input type="text" name="invThumbnail" id="invThumbnail" placeholder="Thumbnail Path" value="/phpmotors/images/no-image/no-image.png">

                <label for="price">Price:</label>
                <input type="number" name="price" id="price" placeholder="Price" step="0.01">

                <label for="stock">Stock:</label>
                <input type="number" name="stock" id="stock" placeholder="Stock">

                <label for="invColor">Color:</label>
                <input type="text" name="invColor" id="invColor" placeholder="Color">

                <button type="submit">Add Vehicle</button>
            </form>
        </main>
        <footer>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
        </footer>
        <script src="scripts/last_updated.js"></script>
    </div>
</body>
</html>