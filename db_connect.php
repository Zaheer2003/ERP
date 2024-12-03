<?php
$host = 'cberp.mysql.database.azure.com';      // Replace with your host (e.g., localhost)
$dbname = 'cberp';        // Replace with your database name
echo $username = 'Zaheer';       // Replace with your database username
$password = 'Khan12@@';           // Replace with your database password

try {
    // Establish a PDO connection to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    
    // Set error mode to exceptions for better debugging
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Optional: Set default fetch mode to associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Optional: Disable emulated prepared statements for true prepared statements
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

} catch (PDOException $e) {
    // Display a user-friendly error message
    die("Database connection failed: " . $e->getMessage());
}
?>
