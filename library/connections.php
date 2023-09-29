<?php
/*
* Proxy connection to the phpmotors database
 */

function phpmotorsConnect()
{
    $server = 'localhost';
    $dbname= 'phpmotors';
    $username = 'iClient';
    $password = 'gKUl*MG12kZ7p5xg'; 
    $dsn = "mysql:host=$server;dbname=$dbname";
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

    // Create the actual connection object and assign it to a variable
    try {
    $link = new PDO($dsn, $username, $password, $options);

    return $link;

    /*if (is_object($link)) {
        echo 'Woohoo! It is working!!!';
    }*/

    } catch (PDOException $e) {
        /*echo 'Connection failed: ' . $e->getMessage();*/
        header('Location: /phpmotors/view/500.php');
        exit;
    }
}
