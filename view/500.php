<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/base.css?v=<?php echo time(); ?>">
    <link rel="icon" type="image/ico" href="images/site/logo.png">
    <title>500</title>
</head>
<body>
    <div class=border>
        <header>
        <img src="../images/site/logo.png" alt="PHP Motors Logo"><div class="account_link">
        <div class="account_link">
            <a href="#">My Account</a>
        </div>
        </header>
        <nav>
        <ul>
            <li><a href="../home.php">Home</a></li>
            <li><a href="#">Classic</a></li>
            <li><a href="#">Sports</a></li>
            <li><a href="#">SUV</a></li>
            <li><a href="#">Trucks</a></li>
            <li><a href="#">Used</a></li>
        </ul>
        </nav>
        <main>
            <h1>Server Error</h1>
            <h2 class="boring_text">Sorry our server seems to be experiencing some technical difficulties. Please check back later.</h2>
        </main>
        <footer>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
        </footer>
        <script src="/phpmotors/scripts/last_updated.js"></script>
    </div>
</body>
</html>