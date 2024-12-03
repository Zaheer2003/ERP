<?php
include("Header.php");
include("db_connect.php");

$search = isset($_GET['search']) ? $_GET['search'] : '';

// Pagination setup
$limit = 10;  // Number of employees per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// SQL query to search employees based on first_name
$query = "SELECT * FROM employees WHERE firstName LIKE :search LIMIT $limit OFFSET $offset";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);

// Execute the query
try {
    $stmt->execute();
    $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die('Error fetching employees: ' . $e->getMessage());
}

// Get the total number of employees
$totalEmployeesQuery = "SELECT COUNT(*) FROM employees WHERE firstName LIKE :search";
$stmt = $pdo->prepare($totalEmployeesQuery);
$stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
try {
    $stmt->execute();
    $totalEmployees = $stmt->fetchColumn();
} catch (Exception $e) {
    die('Error fetching total employees count: ' . $e->getMessage());
}

// Calculate the total number of pages
$totalPages = ceil($totalEmployees / $limit);
?>

<style>
    .badge-active {
        background-color: #28a745;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
    }

    .badge-inactive {
        background-color: #dc3545;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
    }

    .user-img {
        border-radius: 50%;
        width: 40px;
        height: 40px;
        object-fit: cover;
    }

    .pagination a {
        margin: 0 5px;
        padding: 8px 12px;
        border: 1px solid #007bff;
        color: #007bff;
        text-decoration: none;
        border-radius: 5px;
    }

    .pagination a.active {
        background-color: #007bff;
        color: white;
    }

    .pagination a:hover {
        background-color: #f1f1f1;
    }

    /* Additional styles for button placement */
    .table-actions a {
        margin-right: 5px;
    }
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <!-- Card Component for Search and Filters -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Search and Filters</h4>
                </div>

                <form action="#" class="p-4" method="get">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="searchEmployees" class="form-label">Search Employees</label>
                                <input 
                                    type="text" 
                                    name="search" 
                                    id="searchEmployees" 
                                    class="form-control" 
                                    placeholder="Search Employees" 
                                    value="<?php echo htmlspecialchars($search); ?>" 
                                    aria-label="Search Employees"
                                    onkeyup="searchEmployees()" 
                                />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="statusFilter" class="form-label">Filter by Status</label>
                                <select 
                                    class="form-control" 
                                    id="statusFilter" 
                                    name="statusFilter" 
                                    onchange="filterEmployees()"
                                >
                                    <option value="">All Statuses</option>
                                    <option value="active" <?php echo ($statusFilter == 'active') ? 'selected' : ''; ?>>Active</option>
                                    <option value="inactive" <?php echo ($statusFilter == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col text-end">
                            <button type="reset" class="btn btn-secondary">Clear All</button>
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div class="card mt-5 shadow-sm">
    <div class="card-body">
        <!-- Action Buttons (Add Clients, Print, Export) -->
        <div class="row mt-4">
            <!-- Add Clients Button -->
            <div class="col-md-8">
                <div class="form-group">
                    <a href="AddClients.php" class="btn btn-success mb-3">
                        <i class="fas fa-plus-circle"></i> Add Clients
                    </a>
                </div>
            </div>

            <!-- Print and Export Buttons -->
            <div class="col-md-4">
                <div class="form-group">
                    <a href="#" class="btn btn-primary mb-3">
                        <i class="fas fa-print"></i> Print Table
                    </a>
                    <a href="#" class="btn btn-info mb-3">
                        <i class="fas fa-file-excel"></i> Export to Excel
                    </a>
                </div>
            </div>
        </div>

        <!-- Employee Table -->
        <div class="table-responsive mt-3">
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Employee ID</th>
                        <th>Employee</th>
                        <th>Email Address</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($employees)): ?>
                        <?php foreach ($employees as $employee): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($employee['id']); ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?php echo !empty($employee['employeePicture']) ? htmlspecialchars($employee['employeePicture']) : 'default-avatar.jpg'; ?>" class="user-img" alt="User Image" />
                                        <span class="ml-2"><?php echo htmlspecialchars($employee['firstName'] . ' ' . $employee['surname']); ?></span>
                                    </div>
                                </td>
                                <td><?php echo htmlspecialchars($employee['emailAddress']); ?></td>
                                <td><?php echo htmlspecialchars($employee['role']); ?></td>
                                <td>
                                    <span class="badge <?php echo ($employee['status'] == 'Active') ? 'badge-success' : 'badge-danger'; ?>">
                                        <?php echo htmlspecialchars($employee['status']); ?>
                                    </span>
                                </td>
                                <td class="table-actions">
                                    <a href="ViewEmployee.php?id=<?php echo urlencode($employee['id']); ?>" class="btn btn-sm btn-light" title="View Employee">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="EditEmployee.php?id=<?php echo urlencode($employee['id']); ?>" class="btn btn-sm btn-warning" title="Edit Employee">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="DeleteEmployee.php?id=<?php echo urlencode($employee['id']); ?>" class="btn btn-sm btn-danger" title="Delete Employee">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No employees found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



            <!-- Pagination -->
            <div class="pagination text-center">
                <?php if ($page > 1): ?>
                    <a href="ManageEmployee.php?page=<?php echo $page - 1; ?>&search=<?php echo htmlspecialchars($search); ?>">« Prev</a>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="ManageEmployee.php?page=<?php echo $i; ?>&search=<?php echo htmlspecialchars($search); ?>" class="<?php echo ($i == $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>
                <?php if ($page < $totalPages): ?>
                    <a href="ManageEmployee.php?page=<?php echo $page + 1; ?>&search=<?php echo htmlspecialchars($search); ?>">Next »</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'Footer.php'; ?>
