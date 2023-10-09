<?php
// Include the file that defines phpmotorsConnect()
include '../library/connections.php';

// Example 1: fetch() Method
$db = phpmotorsConnect();
$stmt = $db->prepare('SELECT * FROM inventory WHERE invId = 2'); // Retrieve a specific row by invId
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Display the fetched data
echo "Result from fetch() for Ford Model T: <br>";
echo "Make: " . $row['invMake'] . "<br>";
echo "Model: " . $row['invModel'] . "<br>";
echo "Description: " . $row['invDescription'] . "<br>";



// Example 2: fetchAll() Method
$db = phpmotorsConnect();
$stmt = $db->prepare('SELECT * FROM inventory');
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display all fetched data
echo "Result from fetchAll() for all inventory items: <br>";
foreach ($rows as $row) {
    echo "Make: " . $row['invMake'] . "<br>";
    echo "Model: " . $row['invModel'] . "<br>";
    echo "Description: " . $row['invDescription'] . "<br>";
    // Add more fields as needed
    echo "<hr>"; // Add a horizontal line between rows
}
