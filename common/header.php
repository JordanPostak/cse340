<div class="above_nav">
    <img src="/phpmotors/images/site/logo.png" alt="PHP Motors Logo">
    <div class="account_link">
        <?php
            if (isset($_SESSION['loggedin']) && isset($_SESSION['clientData']['clientFirstname'])) {
                echo '<a href="/phpmotors/accounts/index.php?action=logout">' . 'Log out' . '</a>';
            } else {
                echo '<a href="/phpmotors/accounts/index.php?action=loginview">' . 'My Account' . '</a>';
            }
        ?>
    </div>
    <div class="welcome">
        <?php
        if (isset($_SESSION['loggedin']) && isset($_SESSION['clientData']['clientFirstname'])) {
            echo '<a href="/phpmotors/accounts/index.php?action=admin">Welcome ' . $_SESSION['clientData']['clientFirstname'] . '</a>';
        }
        ?>
    </div>
</div>






