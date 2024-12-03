<?php
// Include necessary files
include 'Header.php'; // The header file (navigation, etc.)
include 'db_connect.php'; // Ensure the database connection is included

// Get EmployeeId from URL
$employeeId = $_GET['EmployeeId'];

// Check if the EmployeeId is valid
if (empty($employeeId)) {
    echo "Invalid employee ID!";
    exit;
}

// Prepare the delete query
$deleteQuery = "DELETE FROM employees WHERE EmployeeId = :employeeId";
$stmt = $pdo->prepare($deleteQuery);
$stmt->bindParam(':employeeId', $employeeId, PDO::PARAM_INT);

// Execute the query to delete the employee
if ($stmt->execute()) {
    echo "Employee deleted successfully!";
    // Redirect to the manage employee page
    header("Location: mMnageEmployee.php");
    exit;
} else {
    echo "Failed to delete employee.";
}

// Include the footer
include 'Footer.php';
?>
