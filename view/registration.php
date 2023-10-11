<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/base.css?v=<?php echo time(); ?>">
    <link rel="icon" type="image/ico" href="../images/site/logo.png">
    <title>PHP Motors registration</title>
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
            <h1>Register</h1>

            <div class="message-container">
                <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>
            </div>

            <form action="/phpmotors/accounts/index.php" method="post">
                <label for="firstName">First Name:</label>
                <input type="text" id="firstName" name="clientFirstname">

                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" name="clientLastname">

                <label for="email">Email Address:</label>
                <input type="email" id="email" name="clientEmail">

                <label for="password">Password:</label>
                <input type="password" id="password" name="clientPassword">
                <h2>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</h2>

                <button type="submit">Register</button>
                <!-- Add the action name - value pair -->
                <input type="hidden" name="action" value="register">
            </form>
        </main>
        <footer>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
        </footer>
        <script src="/phpmotors/scripts/last_updated.js"></script>
    </div>
</body>
</html>