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
        <main class="centered-content">
            <h1>Welcome, <?php echo $_SESSION['clientData']['clientFirstname']; ?></h1>

            <?php
            // Check if a message exists in the session
            if (isset($_SESSION['message'])) {
                echo '<p>' . $_SESSION['message'] . '</p>';
                unset($_SESSION['message']); // Remove the message from the session to prevent it from displaying again
            }
            ?>

            <ul>
                <li>First name: <?php echo $_SESSION['clientData']['clientFirstname']; ?></li>
                <li>Last name: <?php echo $_SESSION['clientData']['clientLastname']; ?></li>
                <li>Email Address: <?php echo $_SESSION['clientData']['clientEmail']; ?></li>
            </ul>
            <div class="cool_link">
                <p><a href="/phpmotors/accounts/?action=update" class="manage_button">Update Account Information</a></p>
            </div>
            <?php
            // Check clientLevel to determine if the buttons and heading should be displayed
            if ($_SESSION['clientData']['clientLevel'] > 1) {
                echo '<h2>Administer Inventory</h2>';
                echo '<p>Administrative clients can use the link below to manage the inventory.</p>';
                echo '<p><a href="/phpmotors/vehicles/" class="manage_button">Manage Vehicles</a></p>';
            }
            ?>
        </main>
        <footer>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
        </footer>
    </div>
    <script src="/phpmotors/scripts/last_updated.js"></script>
</body>
</html>