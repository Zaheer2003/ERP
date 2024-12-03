<?php
// Include necessary files
include 'Header.php';
include 'db_connect.php';

// Check if PDO connection is established
if (!$pdo) {
    die("Database connection failed.");
}

// Update query
$query = "SELECT  name, business_name, telephone, FROM clients";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>

<div class="container mt-5">
    <h2 class="mb-4">Clients Contact List </h2>

    <!-- Add Client Button -->
    <a href="AddClient.php" class="btn btn-success mb-3">
        <i class="fas fa-plus-circle"></i> Add Client
    </a>

    <!-- Add Print and Excel Buttons -->
    <a href="#" onclick="printTable()" class="btn btn-info mb-3">
        <i class="fas fa-print"></i> Print Table
    </a>
    <a href="#" onclick="exportToExcel()" class="btn btn-primary mb-3">
        <i class="fas fa-file-excel"></i> Export to Excel
    </a>

    <table class="table table-striped table-hover" id="clientTable">
        <thead>
            <tr>      
                <th>Client Name</th>
                <th>Phone</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($clients as $client) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars( $client['name']) . "</td>";
                echo "<td>" . htmlspecialchars($client['telephone']) . "</td>";
                echo "<td>
                         <div class='dropdown'>
                            <button class='btn btn-light btn-sm dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                                <i class='fas fa-ellipsis-v'></i>
                            </button>
                            <ul class='dropdown-menu dropdown-menu-end'>
                                <li>
                                    <a class='dropdown-item' href='EditClient.php?id=" . $client['id'] . "'>
                                        <i class='fas fa-edit'></i> Edit
                                    </a>
                                </li>
                                <li>
                                    <a class='dropdown-item text-danger' href='DeleteClient.php?id=" . $client['id'] . "' onclick='return confirm(\"Are you sure you want to delete this client?\")'>
                                        <i class='fas fa-trash-alt'></i> Delete
                                    </a>
                                </li>
                                <li>
                                    <a class='dropdown-item' href='#' onclick='printRow(this)'>
                                        <i class='fas fa-print'></i> Print
                                    </a>
                                </li>
                                <li>
                                    <a class='dropdown-item' href='#' onclick='exportRowToExcel(this)'>
                                        <i class='fas fa-file-excel'></i> Export to Excel
                                    </a>
                                </li>
                            </ul>
                        </div>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- JavaScript for Print and Export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
<script>
// Function to print a single row with headers
function printRow(button) {
    let row = button.closest('tr');
    let rowData = [
        [ 'Client Name', 'Phone'],  // Updated Table headers
        [
            row.cells[0].innerText.trim(),
            row.cells[1].innerText.trim(),
            row.cells[2].innerText.trim(),
            row.cells[3].innerText.trim(),
            row.cells[4].innerText.trim()  // Updated to show Address
        ]
    ];

    let printWindow = window.open('', '', 'height=400,width=800');
    printWindow.document.write('<html><head><title>Print Client</title>');
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
        [ 'Client Name', 'Phone'],  // Updated Table headers
        [
            row.cells[0].innerText.trim(),
            row.cells[1].innerText.trim(),
            row.cells[2].innerText.trim(),
            row.cells[3].innerText.trim(),
            row.cells[4].innerText.trim()  // Updated to show Address
        ]
    ];

    let worksheet = XLSX.utils.aoa_to_sheet(rowData);
    let workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, "Client");
    XLSX.writeFile(workbook, "client.xlsx");
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
    const printTitle = `<h2 class="text-center mb-4">Client Management</h2>`;

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
    let table = document.getElementById('clientTable').cloneNode(true);

    // Remove the last column (Actions column) from each row
    let rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        row.removeChild(row.lastElementChild); // Remove the last cell (Actions column)
    });

    // Also remove the last header column (Actions header)
    let headers = table.querySelectorAll('thead th');
    headers[headers.length - 1].remove(); // Remove the last header (Actions column)

    // Generate Excel file from the modified table (without Actions column)
    let workbook = XLSX.utils.table_to_book(table, { sheet: "Clients" });
    XLSX.writeFile(workbook, 'Clients.xlsx');
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


<div>

<?php include 'Footer.php'; ?>
