<?php
// Include necessary files
include 'Header.php'; // The header file (navigation, etc.)
include 'db_connect.php'; // Ensure the database connection is included

// Ensure 'id' is set in the URL (instead of 'EmployeeId')
if (!isset($_GET['id'])) {
    echo "Employee ID not provided!";
    exit;
}

$employeeId = $_GET['id']; // Get 'id' from the URL

// Prepare and execute the query to fetch the employee data
$query = "SELECT * FROM employees WHERE id = :employeeId"; // Make sure the column is 'id'
$stmt = $pdo->prepare($query);
$stmt->bindParam(':employeeId', $employeeId, PDO::PARAM_INT);
$stmt->execute();

// Fetch the employee data
$employee = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the employee exists
if (!$employee) {
    echo "Employee not found!";
    exit;
}
?>

<div class="container mt-4">
    <!-- Error Message Label (hidden by default) -->
    <div id="lblErrorMessage" class="alert alert-danger" style="display: none;"></div>

    <form class="form-horizontal" method="post" action="UpdateEmployee.php">
        <!-- Employee Name and Picture Section -->
        <div class="form-group row">
            <!-- Employee Name Section (Left) -->
            <div class="col-sm-6">
                <label class="control-label">Employee Name:</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars($employee['first_name'] . ' ' . $employee['middle_name'] . ' ' . $employee['surname']); ?>" readonly />
            </div>

            <!-- Employee Picture Section (Right) -->
            <div class="col-sm-6 text-right">
                <label class="control-label">Employee Picture:</label>
                <img src="<?php echo !empty($employee['employee_picture']) && file_exists($employee['employee_picture']) ? htmlspecialchars($employee['employee_picture']) : 'default-avatar.jpg'; ?>" class="img-thumbnail" width="150" height="150" alt="Employee Picture" />
            </div>
        </div>

        <!-- Employee Information Section -->
        <div class="row mt-4">
            <h3>Employee Information</h3>

            <div class="form-group">
                <label class="col-sm-2 control-label">Mobile Number:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($employee['mobile_number']); ?>" readonly />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Address Line 1:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($employee['address_line1']); ?>" readonly />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Address Line 2:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($employee['address_line2']); ?>" readonly />
                </div>
            </div>
        </div>

        <!-- Account Information Section -->
        <div class="row mt-4">
            <h3>Account Information</h3>

            <div class="form-group">
                <label class="col-sm-2 control-label">Email Address:</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" value="<?php echo htmlspecialchars($employee['email_address']); ?>" readonly />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Role:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($employee['role']); ?>" readonly />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Display Language:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($employee['display_language']); ?>" readonly />
                </div>
            </div>
        </div>

        <!-- Actions Section -->
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <a href="UpdateEmployee.php?id=<?php echo htmlspecialchars($employee['id']); ?>" class="btn btn-primary">Edit</a>
                <a href="DeleteEmployee.php?id=<?php echo htmlspecialchars($employee['id']); ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this employee?');">Delete</a>
            </div>
        </div>
    </form>
</div>

<?php
// Include the footer
include 'Footer.php';
?>
