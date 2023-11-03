<?php
    // Check if the visitor is NOT logged in
    if (!isset($_SESSION['loggedin'])) {
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
    <title>PHP Motors</title>
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
        <h1>Welcome, <?php echo $_SESSION['clientData']['clientFirstname']; ?></h1>
        <ul>
            <li>First name: <?php echo $_SESSION['clientData']['clientFirstname']; ?></li>
            <li>Last name: <?php echo $_SESSION['clientData']['clientLastname']; ?></li>
            <li>Email Address: <?php echo $_SESSION['clientData']['clientEmail']; ?></li>
        </ul>
        <div class="cool_link">
        <?php
            // Check clientLevel to determine if the button should be displayed
            if ($_SESSION['clientData']['clientLevel'] > 1) {
                echo '<p><a href="/phpmotors/vehicles/"><button class="manage_button">Manage Vehicles</button></a></p>';
            }
        ?>
        </div>
        </main>
        <footer>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
        </footer>
        <script src="/phpmotors/scripts/last_updated.js"></script>
    </div>
</body>
</html>