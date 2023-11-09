<?php
// Check if the visitor is NOT logged in
if (!isset($_SESSION['loggedin'])) {
    header("Location: /phpmotors/");
    exit;
}

// Define variables for sticky form fields
$clientFirstname = $_SESSION['clientData']['clientFirstname'];
$clientLastname = $_SESSION['clientData']['clientLastname'];
$clientEmail = $_SESSION['clientData']['clientEmail'];
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/base.css?v=<?php echo time(); ?>">
    <link rel="icon" type="image/ico" href="images/site/logo.png">
    <title>Client Update</title>
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
            <div class="form-container">
                <h1>Account Update</h1>

                <?php
            // Check if a message exists in the session
            if (isset($_SESSION['message'])) {
                echo '<p>' . $_SESSION['message'] . '</p>';
                unset($_SESSION['message']); // Remove the message from the session to prevent it from displaying again
            }
            ?>

                <form action="/phpmotors/accounts/" method="post">
                    <input type="hidden" name="action" value="updateAccount">
                    <input type="hidden" name="clientId" value="<?php echo $_SESSION['clientData']['clientId']; ?>">

                    <label for="clientFirstname">First Name:</label>
                    <input type="text" id="clientFirstname" name="clientFirstname" value="<?php echo htmlspecialchars($clientFirstname); ?>" required>

                    <label for="clientLastname">Last Name:</label>
                    <input type="text" id="clientLastname" name="clientLastname" value="<?php echo htmlspecialchars($clientLastname); ?>" required>

                    <label for="clientEmail">Email Address:</label>
                    <input type="email" id="clientEmail" name="clientEmail" value="<?php echo htmlspecialchars($clientEmail); ?>" required>

                    <button class="manage_button" type="submit">Update Account</button>
                </form>

                <h1>Change Password</h1>
                <form action="/phpmotors/accounts/" method="post">
                    <input type="hidden" name="action" value="updatePassword">
                    <input type="hidden" name="clientId" value="<?php echo $_SESSION['clientData']['clientId']; ?>">

                    <p>By entering a new password, you will change your current password. Make sure to follow the password requirements.</p>

                    <label for="clientPassword">New Password:</label>
                    <span class="password-requirements">Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</span>
                    <input type="password" id="clientPassword" name="clientPassword" required>

                    <button class="manage_button" type="submit">Change Password</button>
                </form>
            </div>
        </main>
        <footer>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
        </footer>
        <script src="/phpmotors/scripts/last_updated.js"></script>
    </div>
</body>
</html>