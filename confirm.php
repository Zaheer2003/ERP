
<?php
session_start();
include('LRHeader.php'); 
include('db_connect.php'); // Include database connection settings

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    // Find user with the provided verification code
    $query = "SELECT * FROM users WHERE verification_code = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$code]);

    if ($stmt->rowCount() > 0) {
        // User found, mark as verified
        $updateQuery = "UPDATE users SET is_verified = 1 WHERE verification_code = ?";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->execute([$code]);

        echo "Your account has been verified! You can now <a href='Login.php'>Login</a>.";
    } else {
        echo "Invalid verification code.";
    }
} else {
    echo "No verification code provided.";
}
?>

<?php include('LRFooter.php'); ?> 
