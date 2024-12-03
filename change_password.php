<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cberp";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

// Check if user is logged in and has a valid session
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "User not logged in"]);
    exit;
}

$currentPassword = $_POST['currentPassword'];
$newPassword = $_POST['newPassword'];
$userId = $_SESSION['user_id'];

// Fetch the current password hash
$sql = "SELECT password FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($dbPassword);
$stmt->fetch();
$stmt->close();

// Debugging: Check if password is fetched
if ($dbPassword === null) {
    echo json_encode(["success" => false, "message" => "User not found"]);
    exit;
}

// Check if the current password matches
if (password_verify($currentPassword, $dbPassword)) {
    // Hash the new password
    $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update the password
    $sql = "UPDATE users SET password = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $newPasswordHash, $userId);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update password"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Incorrect current password", "dbPassword" => $dbPassword, "currentPassword" => $currentPassword]);
}

$stmt->close();
$conn->close();
?>
