<?php
// Include necessary files
include 'Header.php';
include 'db_connect.php';

// Check if PDO connection is established
if (!$pdo) {
    die("Database connection failed.");
}

$query = "SELECT id, itemName, sellingPrice, initialStock, status, lowStockThreshold FROM products";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>







<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <!-- Card Component -->
            <div class="card shadow-sm">
                <!-- Card Header -->
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Search and Filters</h4>
                </div>

                <!-- Form Section -->
                <form action="#" class="p-4">
                    <div class="row g-3">
                        <!-- Search Products -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="searchProducts" class="form-label">Search Products</label>
                                <input 
                                    type="text" 
                                    id="searchProducts" 
                                    class="form-control" 
                                    placeholder="Type product name..." 
                                    onkeyup="searchProducts()" 
                                    aria-label="Search Products"
                                />
                            </div>
                        </div>

                        <!-- Filter by Status -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="statusFilter" class="form-label">Filter by Status</label>
                                <select 
                                    class="form-control" 
                                    id="statusFilter" 
                                    onchange="filterProducts()" 
                                    aria-label="Filter by Status"
                                >
                                    <option value="" selected>All Statuses</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col text-end">
                            <button type="button" class="btn btn-secondary" onclick="resetFilters()">Clear All</button>
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="row">
        <div class="col-lg-12">
            <!-- Products Table -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Products</h4>
                </div>
                <div class="card-body">
                    <!-- Action Buttons -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <a href="AddProducts.php" class="btn btn-success"><i class="fas fa-plus-circle"></i> Add Products</a>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <a href="#" class="btn btn-primary me-2"><i class="fas fa-print"></i> Print Table</a>
                            <a href="#" class="btn btn-info"><i class="fas fa-file-excel"></i> Export to Excel</a>
                        </div>
                    </div>

                    <!-- Product Table -->
                    <div class="table-responsive mt-3">
                    <table class="table table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Item Name</th>
                                <th>Selling Price</th>
                                <th>Available Stock</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $row): ?>
                                <?php 
                                    $stockIcon = ($row['initialStock'] < $row['lowStockThreshold']) 
                                        ? 'fas fa-exclamation-triangle text-warning' 
                                        : 'fas fa-check-circle text-success';
                                    $statusClass = ($row['status'] == 'active') ? 'badge-success' : 'badge-danger';
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['itemName']); ?></td>
                                    <td><?= number_format($row['sellingPrice'], 2); ?></td>
                                    <td><i class="<?= $stockIcon; ?>"></i> <?= $row['initialStock']; ?></td>
                                    <td><span class="badge <?= $statusClass; ?>"><?= ucfirst($row['status']); ?></span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item" href="EditProduct.php?id=<?= $row['id']; ?>">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-danger" href="DeleteProduct.php?id=<?= $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this product?')">
                                                        <i class="fas fa-trash-alt"></i> Delete
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" onclick="printRow(this)">
                                                        <i class="fas fa-print"></i> Print
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" onclick="exportRowToExcel(this)">
                                                        <i class="fas fa-file-excel"></i> Export to Excel
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- JavaScript for Print and Export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
<script>
// Function to print a single row
// Function to print a single row with headers
function printRow(button) {
    let row = button.closest('tr');
    let rowData = [
        ['Item Name', 'Selling Price', 'Available Stock', 'Status'],  // Table headers
        [
            row.cells[0].innerText.trim(),
            row.cells[1].innerText.trim(),
            row.cells[2].innerText.trim(),
            row.cells[3].innerText.trim()
        ]
    ];

    let printWindow = window.open('', '', 'height=400,width=800');
    printWindow.document.write('<html><head><title>Print Product</title>');
    printWindow.document.write('</head><body><table border="1" style="width:100%; border-collapse:collapse;">');

    // Add table headers and row data
    rowData.forEach(function(rowArray) {
        printWindow.document.write('<tr>');
        rowArray.forEach(function(cellData) {
            printWindow.document.write('<td>' + cellData + '</td>');
        });
        printWindow.document.write('</tr>');
    });

    printWindow.document.write('</table></body></html>');
    printWindow.document.close();
    printWindow.print();
}

// Function to export a single row to Excel with headers
function exportRowToExcel(button) {
    let row = button.closest('tr');
    let rowData = [
        ['Item Name', 'Selling Price', 'Available Stock', 'Status'],  // Table headers
        [
            row.cells[0].innerText.trim(),
            row.cells[1].innerText.trim(),
            row.cells[2].innerText.trim(),
            row.cells[3].innerText.trim()
        ]
    ];

    let worksheet = XLSX.utils.aoa_to_sheet(rowData);
    let workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, "Product");
    XLSX.writeFile(workbook, "product.xlsx");
}

function printTable() {
    // Clone the table to avoid modifying the original
    const tableClone = document.querySelector('.table').cloneNode(true);

    // Get all rows in the table (excluding the header)
    const rows = tableClone.querySelectorAll('tbody tr');

    // Loop through each row and remove the last cell (the Actions column)
    rows.forEach(row => {
        row.removeChild(row.lastElementChild); // Remove the last cell (Actions column)
    });

    // Add a title to the printed content
    const printTitle = `<h2 class="text-center mb-4">Product Management</h2>`;

    // Get the HTML of the modified table (without Actions column)
    const printContent = tableClone.outerHTML;

    // Open a new window and write the content to it
    const printWindow = window.open('', '', 'width=800,height=600');
    printWindow.document.write('<html><head><title>Print Table</title>');
    printWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">'); // Include Bootstrap CSS
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: Arial, sans-serif; padding: 20px; }');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; }');
    printWindow.document.write('th, td { padding: 8px 12px; text-align: left; border: 1px solid #ddd; }');
    printWindow.document.write('th { background-color: #f2f2f2; }');
    printWindow.document.write('</style>'); // Add custom styles
    printWindow.document.write('</head><body>');
    printWindow.document.write(printTitle);  // Title
    printWindow.document.write(printContent); // Table content
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print(); // Trigger the print dialog
}


function exportToExcel() {
    // Clone the table for manipulation
    let table = document.getElementById('productTable').cloneNode(true);

    // Remove the last column (Actions column) from each row
    let rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        row.removeChild(row.lastElementChild); // Remove the last cell (Actions column)
    });

    // Also remove the last header column (Actions header)
    let headers = table.querySelectorAll('thead th');
    headers[headers.length - 1].remove(); // Remove the last header (Actions column)

    // Generate Excel file from the modified table (without Actions column)
    let workbook = XLSX.utils.table_to_book(table, { sheet: "Products" });
    XLSX.writeFile(workbook, 'Products.xlsx');
}

function searchProducts() {
    let input = document.getElementById('searchInput').value.toLowerCase();
    let rows = document.querySelectorAll('#productTable tbody tr');

    rows.forEach(row => {
        let name = row.cells[0].innerText.toLowerCase();
        row.style.display = name.includes(input) ? '' : 'none';
    });
}




</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

<!-- Custom CSS -->
<style>
/* Table Enhancements */
.table-hover tbody tr:hover {
    background-color: #f9f9f9;
}

.table th, .table td {
    vertical-align: middle;
}

/* Dropdown alignment and style */
.dropdown-menu-end {
    right: 0;
    left: auto;
}

.btn-light {
    background-color: #ffffff;
    border: 1px solid #ccc;
    color: #555;
}

.btn-light:hover {
    background-color: #e9ecef;
}

/* Add spacing to icons */
.dropdown-item i {
    margin-right: 8px;
}
</style>

<?php include 'Footer.php'; ?>
