<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/base.css?v=<?php echo time(); ?>">
    <link rel="icon" type="image/ico" href="images/site/logo.png">
    <title>PHP Motors</title>
</head>
<body>
    <div class="border">
        <header>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
        </header>
        <nav>
             <?php //require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/navigation.php'; 
             echo $navList; ?> 
        </nav>
        <main>
            <h1>Welcome to PHP Motors!</h1>
            <div class="hero">
                <div class="own_card">
                    <h2>DMC Delorean</h2>
                    <h3>3 Cup holders</h3>
                    <h3>Superman doors</h3>
                    <h3>Fuzzy dice!</h3>
                </div>
                <img src="images/delorean.jpg" alt="delorean">
                <button class=own_button>Own Today</button>
            </div>
            <div class="toggle_bot">
                <div class="reviews">
                    <h1>DMC Delorean Reviews</h1>
                    <ul>
                        <li>"So fast its almost like traveling in time." (4/5)</li>
                        <li>"Coolest ride on the road." (4/5)</li>
                        <li>"I'm feeling Marty McFly!" (5/5)</li>
                        <li>"The most futuristic ride of our day."</li>
                        <li>"80's livin and I love it!" (5/5)</li>
                    </ul>
                </div>
                <div class="upgrades">
                    <h1>Delorean Upgrades</h1>
                    <div class="card_grid">
                        <div class="flux_card">
                            <div class=card>
                            <img src="images/upgrades/flux-cap.png" alt="flux capacitor">
                            </div>
                            <a href="#">Flux Capacitor</a>
                        </div>
                        <div class="flame_card">
                            <div class="card">
                            <img src="images/upgrades/flame.jpg" alt="flame Decal">
                            </div>
                            <a href="#">Flame Decals</a>
                        </div>
                        <div class="bumper_card">
                            <div class=card>
                            <img src="images/upgrades/bumper_sticker.jpg" alt="bumper sticker">
                            </div>
                            <a href="#">Bumper Stickers</a>
                        </div>
                        <div class="hub_card">
                            <div class="card">
                            <img src="images/upgrades/hub-cap.jpg" alt="Hub Cap">
                            </div>
                            <a href="#">Hub Caps</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
        </footer>
        <script src="/phpmotors/scripts/last_updated.js"></script>
    </div>
</body>
</html>