<?php
// Include necessary files
include 'Header.php'; // The header file (navigation, etc.)
include 'db_connect.php'; // Ensure the database connection is included

// Fetch the employee data using 'id' from the URL
$employeeId = $_GET['id']; // Get EmployeeId from the URL

// Validate EmployeeId parameter
if (empty($employeeId)) {
    echo "Employee ID is missing.";
    exit;
}

// Prepare and execute the query to fetch the employee data
$query = "SELECT * FROM employees WHERE id = :employeeId"; // Ensure column matches the one in your database (id or EmployeeId)
$stmt = $pdo->prepare($query);
$stmt->bindParam(':employeeId', $employeeId, PDO::PARAM_INT);
$stmt->execute();

// Fetch the employee data
$employee = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the employee exists
if (!$employee) {
    echo "Employee not found!<br>";
    var_dump($employee);  // Debug the fetched employee data
    exit;
}

// If the form is submitted, update the employee details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $firstName = $_POST['FirstName'];
    $middleName = $_POST['MiddleName'];
    $surname = $_POST['Surname'];
    $mobileNumber = $_POST['MobileNumber'];
    $addressLine1 = $_POST['AddressLine1'];
    $addressLine2 = $_POST['AddressLine2'];
    $emailAddress = $_POST['EmailAddress'];
    $role = $_POST['Role'];
    $displayLanguage = $_POST['DisplayLanguage'];

    // Update query
    $updateQuery = "UPDATE employees SET 
                    FirstName = :firstName,
                    MiddleName = :middleName,
                    Surname = :surname,
                    MobileNumber = :mobileNumber,
                    AddressLine1 = :addressLine1,
                    AddressLine2 = :addressLine2,
                    EmailAddress = :emailAddress,
                    Role = :role,
                    DisplayLanguage = :displayLanguage
                    WHERE id = :employeeId"; // Ensure column matches the one in your database (id or EmployeeId)

    $stmt = $pdo->prepare($updateQuery);
    $stmt->bindParam(':firstName', $firstName);
    $stmt->bindParam(':middleName', $middleName);
    $stmt->bindParam(':surname', $surname);
    $stmt->bindParam(':mobileNumber', $mobileNumber);
    $stmt->bindParam(':addressLine1', $addressLine1);
    $stmt->bindParam(':addressLine2', $addressLine2);
    $stmt->bindParam(':emailAddress', $emailAddress);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':displayLanguage', $displayLanguage);
    $stmt->bindParam(':employeeId', $employeeId);

    // Execute the update query
    if ($stmt->execute()) {
        echo "Employee details updated successfully!";
        // Redirect to the view page or manage page after successful update
        header("Location: ManageEmployee.php");
        exit;
    } else {
        echo "Failed to update employee details.";
    }
}

?>

<div class="container mt-4">
    <h2>Edit Employee</h2>
    <form method="post">
        <!-- Employee Name and Picture Section -->
        <div class="form-group row">
            <div class="col-sm-6">
                <label class="control-label">First Name:</label>
                <input type="text" class="form-control" name="FirstName" value="<?php echo isset($employee['FirstName']) ? htmlspecialchars($employee['FirstName']) : ''; ?>" required />
            </div>

            <div class="col-sm-6">
                <label class="control-label">Middle Name:</label>
                <input type="text" class="form-control" name="MiddleName" value="<?php echo isset($employee['MiddleName']) ? htmlspecialchars($employee['MiddleName']) : ''; ?>" required />
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-6">
                <label class="control-label">Surname:</label>
                <input type="text" class="form-control" name="Surname" value="<?php echo isset($employee['Surname']) ? htmlspecialchars($employee['Surname']) : ''; ?>" required />
            </div>

            <div class="col-sm-6 text-right">
                <label class="control-label">Employee Picture:</label>
                <img src="<?php echo isset($employee['EmployeePicture']) ? htmlspecialchars($employee['EmployeePicture']) : ''; ?>" class="img-thumbnail" width="150" height="150" alt="Employee Picture" />
            </div>
        </div>

        <!-- Employee Information Section -->
        <div class="form-group">
            <label class="control-label">Mobile Number:</label>
            <input type="text" class="form-control" name="MobileNumber" value="<?php echo isset($employee['MobileNumber']) ? htmlspecialchars($employee['MobileNumber']) : ''; ?>" required />
        </div>

        <div class="form-group">
            <label class="control-label">Address Line 1:</label>
            <input type="text" class="form-control" name="AddressLine1" value="<?php echo isset($employee['AddressLine1']) ? htmlspecialchars($employee['AddressLine1']) : ''; ?>" required />
        </div>

        <div class="form-group">
            <label class="control-label">Address Line 2:</label>
            <input type="text" class="form-control" name="AddressLine2" value="<?php echo isset($employee['AddressLine2']) ? htmlspecialchars($employee['AddressLine2']) : ''; ?>" required />
        </div>

        <!-- Account Information Section -->
        <div class="form-group">
            <label class="control-label">Email Address:</label>
            <input type="email" class="form-control" name="EmailAddress" value="<?php echo isset($employee['EmailAddress']) ? htmlspecialchars($employee['EmailAddress']) : ''; ?>" required />
        </div>

        <div class="form-group">
            <label class="control-label">Role:</label>
            <input type="text" class="form-control" name="Role" value="<?php echo isset($employee['Role']) ? htmlspecialchars($employee['Role']) : ''; ?>" required />
        </div>

        <div class="form-group">
            <label class="control-label">Display Language:</label>
            <input type="text" class="form-control" name="DisplayLanguage" value="<?php echo isset($employee['DisplayLanguage']) ? htmlspecialchars($employee['DisplayLanguage']) : ''; ?>" required />
        </div>

        <!-- Submit Button -->
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update Employee</button>
        </div>
    </form>
</div>

<?php
// Include the footer
include 'Footer.php';
?>
