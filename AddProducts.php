<?php
include 'Header.php';           // Navigation and header
include 'db_connect.php';       // Database connection (Make sure it's using PDO)
include 'form_validation.php';  // Custom validation functions

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = validate_form($_POST);  // Validate form fields
    $photo_errors = [];

    // Handle file upload for the photo
    $photoUpload = null;
    if (!empty($_FILES['photoUpload']['name'])) {
        $target_dir = "uploads/";
        $photo_name = uniqid() . "_" . basename($_FILES['photoUpload']['name']); // Unique file name
        $target_file = $target_dir . $photo_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate the uploaded image
        if (!getimagesize($_FILES['photoUpload']['tmp_name'])) {
            $photo_errors[] = "File is not a valid image.";
        } elseif ($_FILES['photoUpload']['size'] > 500000) {
            $photo_errors[] = "File size exceeds the limit (500KB).";
        } elseif (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            $photo_errors[] = "Only JPG, JPEG, PNG & GIF formats are allowed.";
        } elseif (!move_uploaded_file($_FILES['photoUpload']['tmp_name'], $target_file)) {
            $photo_errors[] = "Error uploading the file.";
        } else {
            $photoUpload = $photo_name;  // Save file name for database insertion
        }
    }

    // Validate SKU: Ensure it's alphanumeric (adjust regex if needed)
    if (empty($_POST['itemSKU']) || !preg_match('/^[a-zA-Z0-9-]+$/', $_POST['itemSKU'])) {
        $errors[] = 'SKU is required and must be alphanumeric (with optional hyphens).';
    }

    // Proceed if there are no errors
    if (empty($errors) && empty($photo_errors)) {
        // Extract and sanitize form data
        $itemName = trim($_POST['itemName']);
        $itemSKU = trim($_POST['itemSKU']);
        $description = trim($_POST['description']);
        $category = trim($_POST['category']);
        $brand = trim($_POST['brand']);
        $barcode = trim($_POST['barcode']);
        $purchasePrice = floatval($_POST['purchasePrice']);
        $sellingPrice = floatval($_POST['sellingPrice']);
        $minimumPrice = $_POST['minimumPrice'] ? floatval($_POST['minimumPrice']) : null;
        $discount = $_POST['discount'] ? floatval($_POST['discount']) : null;
        $discountType = $_POST['discountType'] ?: null;
        $tax = isset($_POST['tax']) ? floatval($_POST['tax']) : NULL;
        $profitMargin = $_POST['profitMargin'] ? floatval($_POST['profitMargin']) : null;
        $trackStock = isset($_POST['trackStock']) ? 1 : 0;
        $initialStock = $_POST['initialStock'] ? intval($_POST['initialStock']) : 0;
        $lowStockThreshold = $_POST['lowStockThreshold'] ? intval($_POST['lowStockThreshold']) : 0;
        $internalNotes = $_POST['internalNotes'] ?: null;
        $status = $_POST['status'] ?: 'active';
        $tags = $_POST['tags'] ?: null;

        // Prepare the SQL statement (Using PDO)
        $query = "INSERT INTO products (itemName, itemSKU, description, category, brand, barcode, purchasePrice, sellingPrice, minimumPrice, discount, discountType, tax, profitMargin, trackStock, initialStock, lowStockThreshold, internalNotes, status, tags, photoUpload) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        try {
            $stmt = $pdo->prepare($query);  // Use PDO for database interaction
            $stmt->execute([
                $itemName, $itemSKU, $description, $category, $brand, 
                $barcode, $purchasePrice, $sellingPrice, $minimumPrice, 
                $discount, $discountType, $tax, $profitMargin, 
                $trackStock, $initialStock, $lowStockThreshold, 
                $internalNotes, $status, $tags, $photoUpload
            ]);

            echo "<div class='alert alert-success'>Product added successfully!</div>";

        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Database Error: " . $e->getMessage() . "</div>";
        }
    } else {
        // Display validation errors
        foreach (array_merge($errors, $photo_errors) as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    }
}

?>


<form action="AddProducts.php" method="POST" enctype="multipart/form-data">


<div class="container mt-5">
    
    <div class="row">
    
        <!-- Item Details Section -->
        <div class="col-sm-12 col-md-6">
        <section class="border rounded p-4 mb-5">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>Item Details</h4>
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="itemName" class="form-label">Name</label>
                            <input type="text" name="itemName" id="itemName" class="form-control" placeholder="Enter item name" required>
                        </div>
                        <div class="mb-3">
                            <label for="itemSKU" class="form-label">Item SKU</label>
                            <input type="text" name="itemSKU" id="itemSKU" class="form-control" placeholder="Enter item SKU">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="3" placeholder="Enter item description" ></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="photoUpload" class="form-label">Photo</label>
                            <input type="file" name="photoUpload" id="photoUpload" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <input type="text" name="category" id="category" class="form-control" placeholder="Enter category">
                        </div>
                        <div class="mb-3">
                            <label for="brand" class="form-label">Brand</label>
                            <input type="text" name="brand" id="brand" class="form-control" placeholder="Enter brand" >
                        </div>
                        <div class="mb-3">
                            <label for="barcode" class="form-label">Barcode</label>
                            <input type="text" name="barcode" id="barcode" class="form-control" placeholder="Enter barcode" >
                        </div>
                    </form>
                </div>
            </div>
            </section>

        </div>
        
        <!-- Pricing Details Section -->
        <div class="col-sm-12 col-md-6">
        <section class="border rounded p-4 mb-5">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>Pricing Details</h4>
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="purchasePrice" class="form-label">Purchase Price</label>
                            <input type="number" name="purchasePrice" id="purchasePrice" class="form-control" placeholder="Enter purchase price" >
                        </div>
                        <div class="mb-3">
                            <label for="sellingPrice" class="form-label">Selling Price</label>
                            <input type="number" name="sellingPrice" id="sellingPrice" class="form-control" placeholder="Enter selling price" >
                        </div>
                        <div class="mb-3">
                            <label for="minimumPrice" class="form-label">Minimum Price</label>
                            <input type="number" name="minimumPrice" id="minimumPrice" class="form-control" placeholder="Enter minimum price">
                        </div>
                        <div class="mb-3">
                            <label for="discount" class="form-label">Discount</label>
                            <input type="number" name="discount" id="discount" class="form-control" placeholder="Enter discount">
                        </div>
                        <div class="mb-3">
                            <label for="discountType" class="form-label">Discount Type</label>
                            <select name="discountType" id="discountType" class="form-select">
                                <option value="" selected>Select Type</option>
                                <option value="Percentage">%</option>
                                <option value="Fixed Amount">$</option>
                            </select>
                        </div>
                        <!-- Select Box to trigger Modal -->
<div class="mb-3">
    <label for="taxSettings" class="form-label">Tax</label>
    <select class="form-control" id="taxSettings" onchange="showTaxModal()">
        <option value="">Select Tax Setting</option>
        <option value="1">Custom Tax</option>

    </select>
</div>
<!-- Modal for Tax Settings -->
<div class="modal fade" id="taxModal" tabindex="-1" aria-labelledby="taxModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="taxModalLabel">Tax Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Table for Tax Settings -->
                <table class="table table-bordered table-hover" id="taxTable">
                    <thead class="table-light">
                        <tr>
                            <th>Tax Name</th>
                            <th>Tax Value (%)</th>
                            <th>Included</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dynamic Rows will appear here -->
                    </tbody>
                </table>
                <!-- Add Row Button -->
                <button type="button" class="btn btn-success btn-sm" id="addRowBtn" onclick="addTaxRow()">
                    <i class="bi bi-plus"></i> Add Tax
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveTaxes()">Save Changes</button>
            </div>
        </div>
    </div>
</div>
                        <div class="mb-3">
                            <label for="profitMargin" class="form-label">Profit Margin</label>
                            <input type="number" name="profitMargin" id="profitMargin" class="form-control" placeholder="Enter profit margin">
                        </div>
                    </form>
                </div>
            </div>
        </section>
        </div>
 


          
        


            <!-- Inventory Management Section -->
            <section class="border rounded p-4 mb-5">
            <div class="col-sm-15">
            <div class="card">
                <div class="card-header bg-primary text-white">
                <h3 class="mb-4">Inventory Management</h3>
                </div>
                <div class="card-body">
                <div class="form-check">
                    <input type="checkbox" name="trackStock" id="trackStock" class="form-check-input">
                    <label for="trackStock" class="form-check-label">Track Stock</label>
                    <small class="form-text text-muted">Enable this option to track the stock levels of the item.</small>
                </div>
                <div id="stockFields" style="display:none;">
                    <div class="row">
                        
                        <div class="col-md-6 ">
                        <div class="form-group">
                            <label for="initialStock" class="form-label">Initial Stock Level</label>
                            <input type="number" name="initialStock" id="initialStock" class="form-control">
                        </div>
                        </div>
                  
                        <div class="col-md-6 ">
                        <div class="form-group">
                            <label for="lowStockThreshold" class="form-label">Low Stock Level</label>
                            <input type="number" name="lowStockThreshold" id="lowStockThreshold" class="form-control">
                        </div>
                    </div>
                    </div>
                </div>
           
            </div>
            </div>
            </div>
            </section>

           
       


            <!-- More Details Section -->
            <section class="border rounded p-4 mb-5">
            <div class="col-sm-15">
            <div class="card">
                <div class="card-header bg-primary text-white">
                <h3 class="mb-3">More Details</h3>
                </div>
                <div class="card-body">
                <div class="row">
                    
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                        <label for="internalNotes" class="form-label">Internal Notes</label>
                        <textarea name="internalNotes" id="internalNotes" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="tags" class="form-label">Tags</label>
                        <input type="text" name="tags" id="tags" class="form-control">
                    </div>
                </div>
            
            </div>
            </div>
            </div>
            </section>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Add Product</button>
            </div>

      
            </div>
            </div>
        </form>
    

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <!-- JavaScript to show/hide stock fields based on checkbox -->
    <script>
            // Function to show the tax settings modal
    function showTaxModal() {
        var taxSettings = document.getElementById('taxSettings').value;
        if (taxSettings === "1") {
            // Show the modal if Custom Tax is selected
            new bootstrap.Modal(document.getElementById('taxModal')).show();
        }
    }

    // Function to add a row to the tax table
    function addTaxRow() {
        const tableBody = document.getElementById('taxTable').getElementsByTagName('tbody')[0];
        const newRow = tableBody.insertRow();

        const taxNameCell = newRow.insertCell(0);
        const taxValueCell = newRow.insertCell(1);
        const includedCell = newRow.insertCell(2);
        const actionCell = newRow.insertCell(3);

        taxNameCell.innerHTML = '<input type="text" class="form-control" placeholder="Tax Name" required>';
        taxValueCell.innerHTML = '<input type="number" class="form-control" step="0.01" placeholder="Tax Value" required>';
        includedCell.innerHTML = `
            <select class="form-control">
                <option value="exclusive">Exclusive</option>
                <option value="inclusive">Inclusive</option>
            </select>
        `;
        actionCell.innerHTML = '<button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(this)">Delete</button>';
    }

    // Function to delete a row from the table
    function deleteRow(button) {
        const row = button.closest('tr');
        row.remove();
    }

    // Function to save the tax settings
    function saveTaxes() {
        const taxRows = document.getElementById('taxTable').getElementsByTagName('tbody')[0].rows;
        const taxData = [];
        
        for (let row of taxRows) {
            const taxName = row.cells[0].getElementsByTagName('input')[0].value;
            const taxValue = row.cells[1].getElementsByTagName('input')[0].value;
            const included = row.cells[2].getElementsByTagName('select')[0].value;

            if (taxName && taxValue) {
                taxData.push({ taxName, taxValue, included });
            }
        }

        console.log(taxData); // For testing, this will print the collected data to the console

        // You can send taxData to the server or perform other actions here
        alert('Taxes saved successfully!');
        // Close the modal after saving
        bootstrap.Modal.getInstance(document.getElementById('taxModal')).hide();
    }




    // Show/hide stock fields when trackStock checkbox changes
    document.getElementById("trackStock").addEventListener("change", function() {
        document.getElementById("stockFields").style.display = this.checked ? "block" : "none";
    });

    
</script>



<?php
// Include the footer
include 'Footer.php';
?>
