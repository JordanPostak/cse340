<?php 
// Check if the client is logged in and has a clientLevel greater than 1
if (!isset($_SESSION['loggedin']) || $_SESSION['clientData']['clientLevel'] <= 1) {
    header("Location: /phpmotors/");
    exit;
}

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/base.css?v=<?php echo time(); ?>">
    <link rel="icon" type="image/ico" href="../images/site/logo.png">
    <title>Vehicle Management</title>
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
            <h1>Vehicle Management</h1>
            <p><a href="/phpmotors/vehicles/index.php?action=class"><button class="manage_button">Add Classification</button></a></p>
            <p><a href="/phpmotors/vehicles/index.php?action=vehicle"><button class="manage_button">Add Vehicle</button></a></p>
            <div class="table-area">
            <?php
                if (isset($message)) { 
                echo $message; 
                } 
                if (isset($classificationList)) { 
                echo '<h2>Vehicles By Classification</h2>'; 
                echo '<p>Choose a classification to see those vehicles</p>'; 
                echo $classificationList; 
                }
            ?>
            <noscript>
                <p><strong>JavaScript Must Be Enabled to Use this Page.</strong>
                </p>
            </noscript>
            <table id="inventoryDisplay"></table>
            </div>
        </main>
        <footer>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
        </footer>
    </div>
    <script src="/phpmotors/scripts/last_updated.js"></script>
    <script src="/phpmotors/scripts/inventory.js"></script>
</body>
</html>
<?php unset($_SESSION['message']); ?>