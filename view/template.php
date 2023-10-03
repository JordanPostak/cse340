<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/base.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/large.css?v=<?php echo time(); ?>">
    <link rel="icon" type="image/ico" href="images/site/logo.png">
    <title>PHP Motors</title>
</head>
<body>
    <div class=border>
        <header>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
        </header>
        <nav>
             <?php //require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/navigation.php'; 
             echo $navList; ?> 
        </nav>
        <main>
            <h1>Content Title Here</h1>
        </main>
        <footer>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
        </footer>
        <script src="scripts/last_updated.js"></script>
    </div>
</body>
</html>