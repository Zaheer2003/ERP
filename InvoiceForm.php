<?php 
$pageTitle = "Invoice";
include('Header.php'); 

// Database connection details
$host = 'localhost';
$db = 'cberp';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Database connection successful!";
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
}




// Fetch clients from the database
try {
    $stmt = $pdo->query("SELECT * FROM clients");
    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $clients = [];
    error_log("Client query error: " . $e->getMessage());
}

// Fetch products from the database
try {
    $stmt = $pdo->query("SELECT * FROM products");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $products = [];
    error_log("Product query error: " . $e->getMessage());
}

?>

<style>
    .invoice-section {
        padding: 20px;
        background-color: #f8f9fa;
        position: relative;
    }
    .section-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    .form-control:disabled, .form-control[readonly] {
        background-color: #e9ecef;
    }
    .table th, .table td {
        vertical-align: middle;
    }
    .delete-btn {
        color: red;
        cursor: pointer;
    }
    .hidden {
        display: none;
    }
 
</style>




    <div class="container">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="section-header">
                            <div>
                                <button type="button" class="btn btn-primary" onclick="previewInvoice()">Preview</button>
                                <button type="button" class="btn btn-secondary" onclick="saveAsDraft()">Save as Draft</button>
                            </div>
                            <form action="savepdf.php" method="POST" target="_blank">
                                <button type="submit" class="btn btn-success">Save & Print PDF</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<div class="container">
    <div class="row mb-4">

   
    <div class="col-12">
        <div class="card">
            <div class="card-body">
        <div class="row">
    <!-- Invoice Layout Selection (Right) -->
    <div class="col-md-6 offset-md-6">

            <div class="card-body">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="invoiceLayout">Invoice Layout</label>
                        <select class="form-select" id="invoiceLayout" name="invoiceLayout">
                            <option value="default" selected>Default Invoice Layout</option>
                            <option value="retail">Retail Timesheet Layout</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</div>
</div>
</div>

</div>

            


<div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addClientModalLabel">Add New Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addClientForm" novalidate>
                    <div class="mb-3">
                        <label for="fullName" class="form-label">Full Name *</label>
                        <input type="text" class="form-control" id="fullName" name="fullName">
                        <div class="invalid-feedback">Full Name is required.</div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                        <div class="invalid-feedback">Enter a valid email.</div>
                    </div>
                    <div class="mb-3">
                        <label for="address1" class="form-label">Street Address</label>
                        <input type="text" class="form-control" id="address1" name="address1">
                    </div>
                    <div class="mb-3">
                        <label for="address2" class="form-label">Address Line 2</label>
                        <input type="text" class="form-control" id="address2" name="address2">
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">City</label>
                        <input type="text" class="form-control" id="city" name="city">
                    </div>
                    <div class="mb-3">
                        <label for="state" class="form-label">State/Province</label>
                        <input type="text" class="form-control" id="state" name="state">
                    </div>
                    <div class="mb-3">
                        <label for="postalCode" class="form-label">Postal/Zip Code</label>
                        <input type="text" class="form-control" id="postalCode" name="postalCode">
                    </div>
                    <div class="mb-3">
                        <label for="telephone" class="form-label">Telephone</label>
                        <input type="text" class="form-control" id="telephone" name="telephone">
                    </div>
                    <div class="mb-3">
                        <label for="mobile" class="form-label">Mobile</label>
                        <input type="text" class="form-control" id="mobile" name="mobile">
                    </div>
                    <div class="mb-3">
                        <label for="country" class="form-label">Country</label>
                        <select class="form-select" id="country" name="country">
                            <option value="Sri Lanka" selected>Sri Lanka</option>
                            <!-- Add more countries as needed -->
                        </select>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="addShipping" name="addShipping">
                        <label class="form-check-label" for="addShipping">Add Shipping Address</label>
                    </div>
                    <div id="shippingFields" class="d-none">
                        <div class="mb-3">
                            <label for="shippingAddress" class="form-label">Shipping Address</label>
                            <input type="text" class="form-control" id="shippingAddress" name="shippingAddress">
                        </div>
                        <div class="mb-3">
                            <label for="shippingCity" class="form-label">Shipping City</label>
                            <input type="text" class="form-control" id="shippingCity" name="shippingCity">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="currencyModal" tabindex="-1" aria-labelledby="currencyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm"> <!-- Added modal-sm class here -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="currencyModalLabel">Select Currency</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="currency">Currency</label>
                <select class="form-select" id="currency">
                    <option value="LKR" selected>LKR</option>
                    <option value="USD">USD</option>
                    <option value="EUR">EUR</option>
                    <!-- Add more currencies as needed -->
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="updateCurrency">Update</button>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <!-- Client Selection Section (Left) -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <form action="savepdf.php" method="POST">
                    <div class="form-group">
                        <label for="client">Client</label>
                        <div class="d-flex">
                            <select class="form-select" id="client" name="client">
                                <option value="" selected>Select Client</option>
                                <?php foreach ($clients as $client): ?>
                                    <option value="<?= $client['id'] ?>"><?= $client['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type="button" class="btn btn-sm btn-primary ms-2" id="toggleAddClient">
                                + New
                            </button>
                            <button type="button" class="btn btn-sm" id="toggleSelectCurrency" data-bs-toggle="modal" data-bs-target="#currencyModal">LKR</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Invoice Number, Date, and Payment Terms Section (Right) -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <form action="" method="POST">
                    <div class="form-group row">
                        <label for="invoiceNumber" class="col-sm-4 col-form-label">Invoice Number:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="invoiceNumber" name="invoiceNumber" value="000005">
                            <small class="form-text text-muted">This is auto-generated.</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="invoiceDate" class="col-sm-4 col-form-label">Invoice Date:</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" id="invoiceDate" name="invoiceDate">
                            <small class="form-text text-muted">Select the date of the invoice.</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="paymentTerms" class="col-sm-4 col-form-label">Payment Terms:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="paymentTerms" name="paymentTerms" placeholder="Enter number of days" pattern="\d+" title="Only numeric values are allowed">
                            <small class="form-text text-muted">Enter the payment due period in days.</small>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


        




       <!-- Item Table Section -->
<div class="row mb-4">
    <div class="col-12">
        <table class="table table-bordered" id="invoiceTable">
            <thead class="table-light">
                <tr>
                    <th>Item</th>
                    <th>Description</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Discount</th>
                    <th>Tax 1</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="itemRows">
                <tr>
                    <td>
                        <!-- Removed id and added onchange to trigger updateUnitPrice -->
                        <select name="search" class="form-control" onchange="updateUnitPrice(this)">
                            <option value="" disabled selected>Select an Item</option>
                            <?php foreach ($products as $product): ?>
                                <option value="<?= htmlspecialchars($product['itemName'], ENT_QUOTES, 'UTF-8') ?>">
                                    <?= htmlspecialchars($product['itemName'], ENT_QUOTES, 'UTF-8') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td><input type="text" class="form-control" name="description[]"></td>
                    <td><input type="number" class="form-control unit-price" name="unitPrice[]" step="0.01" value="0" oninput="calculateSubtotal(this)"></td>
                    <td><input type="number" class="form-control quantity" name="quantity[]" value="1" oninput="calculateSubtotal(this)"></td>
                    <td><input type="number" class="form-control discount" name="discount[]" step="0.01" value="0" oninput="calculateSubtotal(this)"></td>
                    <td><input type="number" class="form-control tax" name="tax[]" step="0.01" value="0" oninput="calculateSubtotal(this)"></td>
                    <td><input type="text" class="form-control subtotal" name="subtotal[]" readonly value="0"></td>
                    <td class="text-center"><span class="delete-btn" onclick="deleteRow(this)">❌</span></td>
                </tr>
            </tbody>
        </table>
        <button type="button" class="btn btn-primary" onclick="addRow()">+</button>
    </div>
</div>

        <!-- Total Section -->
        <div class="row mb-4">
            <div class="col-md-6 offset-md-6">
                <table class="table">
                    <tr>
                        <th class="text-end">Total:</th>
                        <td><input type="text" class="form-control" id="finalTotal" readonly value="0"></td>
                    </tr>
                </table>
            </div>
        </div>

        



        <div class="container">
        <!-- Discount & Adjustment Section -->
        <div class="row mb-4">
            <div class="col-md-12">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="discount-tab" data-bs-toggle="tab" href="#discount" role="tab" aria-controls="discount" aria-selected="true">Discount & Adjustment</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="deposit-tab" data-bs-toggle="tab" href="#deposit" role="tab" aria-controls="deposit" aria-selected="false">Deposit</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="shipping-tab" data-bs-toggle="tab" href="#shipping" role="tab" aria-controls="shipping" aria-selected="false">Shipping Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="attach-tab" data-bs-toggle="tab" href="#attach" role="tab" aria-controls="attach" aria-selected="false">Attach Documents</a>
                    </li>
                </ul>
                <div class="tab-content p-3 border bg-light" id="myTabContent">
                    <!-- Discount & Adjustment Tab -->
                    <div class="tab-pane fade show active" id="discount" role="tabpanel" aria-labelledby="discount-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="txtDiscount">Discount</label>
                                    <input type="text" id="txtDiscount" name="txtDiscount" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="txtAdjustment">Adjustment</label>
                                    <input type="text" id="txtAdjustment" name="txtAdjustment" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Deposit Tab -->
                    <div class="tab-pane fade" id="deposit" role="tabpanel" aria-labelledby="deposit-tab">
                        <div class="form-group">
                            <label for="txtDeposit">Deposit</label>
                            <input type="text" id="txtDeposit" name="txtDeposit" class="form-control">
                        </div>
                    </div>

                    <!-- Shipping Tab -->
                    <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                        <div class="form-group">
                            <label for="txtShippingDetails">Shipping Details</label>
                            <textarea id="txtShippingDetails" name="txtShippingDetails" class="form-control" rows="3"></textarea>
                        </div>
                    </div>

                    <!-- Attach Documents Tab -->
                    <div class="tab-pane fade" id="attach" role="tabpanel" aria-labelledby="attach-tab">
                        <div class="form-group">
                            <label for="uploadFiles">Upload Files</label>
                            <input type="file" id="uploadFiles" name="uploadFiles[]" class="form-control" multiple>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Notes / Terms Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="invoiceNotes">Notes / Terms</label>
                    <!-- Replace the normal textarea with the CKEditor enhanced textarea -->
                    <textarea class="form-control" id="invoiceNotes" name="invoiceNotes" rows="4" placeholder="Enter any notes or terms here..."></textarea>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container">
    <div class="card">
        <div class="col-sm-12">

  
        <div class="card-body">

        


        <!-- Already Paid Checkbox Section -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="chkAlreadyPaid" name="chkAlreadyPaid" onclick="togglePaymentDetails()">
                    <label class="form-check-label" for="chkAlreadyPaid">Already Paid</label>
                </div>
            </div>
        </div>

        <!-- Payment Details Section (Initially hidden) -->
        <div class="row mb-4 hidden" id="paymentDetailsSection">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="ddlPaymentMethod" class="form-label">Payment Method</label>
                    <select id="ddlPaymentMethod" name="ddlPaymentMethod" class="form-control">
                        <option value="Cash">Cash</option>
                        <option value="Credit Card">Credit Card</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                        <option value="Cheque">Cheque</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="txtReferenceNumber" class="form-label">Ref No.</label>
                    <input type="text" id="txtReferenceNumber" name="txtReferenceNumber" class="form-control" />
                </div>
            </div>
        </div>
        </div>
    </div>
    </div>
    </div>
    </div>


<!-- Save Button -->
<div class="row">
            <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>


</div>



                            
                      
              

    
        



    <script>

        // JavaScript to toggle modal
    // JavaScript to toggle the "Add Client" modal
const toggleAddClientButton = document.getElementById('toggleAddClient');
const addClientModal = new bootstrap.Modal(document.getElementById('addClientModal'));

toggleAddClientButton.addEventListener('click', () => {
    const modalElement = document.getElementById('addClientModal');
    if (modalElement.classList.contains('show')) {
        addClientModal.hide(); // Close the modal if it's open
    } else {
        addClientModal.show(); // Open the modal if it's closed
    }
});

// JavaScript to toggle the "Select Currency" modal
const toggleSelectCurrencyButton = document.getElementById('toggleSelectCurrency');
const currencyModal = new bootstrap.Modal(document.getElementById('currencyModal'));

toggleSelectCurrencyButton.addEventListener('click', () => {
    const modalElement = document.getElementById('currencyModal');
    if (modalElement.classList.contains('show')) {
        currencyModal.hide(); // Close the modal if it's open
    } else {
        currencyModal.show(); // Open the modal if it's closed
    }
});

// JavaScript to toggle shipping address fields
document.getElementById('addShipping').addEventListener('change', function () {
    const shippingFields = document.getElementById('shippingFields');
    if (this.checked) {
        shippingFields.classList.remove('d-none'); // Show shipping fields
    } else {
        shippingFields.classList.add('d-none'); // Hide shipping fields
    }
});

// JavaScript for form validation and submission
document.getElementById('addClientForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Prevent form submission to validate manually

    // Simple client-side validation example (Bootstrap 5)
    const form = e.target;
    if (form.checkValidity() === false) {
        e.stopPropagation();
    } else {
        // Handle the form submission, maybe with AJAX or show a success message
        alert('Client added successfully');
    }
    
    form.classList.add('was-validated'); // Add Bootstrap's validation classes
});


// Initialize CKEditor for each textarea
ClassicEditor
            .create(document.querySelector('#invoiceNotes'))
            .catch(error => {
                console.error(error);
            });






    // Toggle Payment Details visibility
        function togglePaymentDetails() {
            var checkBox = document.getElementById('chkAlreadyPaid');
            var paymentSection = document.getElementById('paymentDetailsSection');

            // Show or hide the payment details section based on checkbox state
            if (checkBox.checked) {
                paymentSection.classList.remove('hidden');
            } else {
                paymentSection.classList.add('hidden');
            }
        }



    // Create a JavaScript object that holds product prices
const productPrices = {
    <?php foreach ($products as $product): ?>
        "<?= $product['itemName'] ?>": <?= $product['sellingPrice'] ?>,
    <?php endforeach; ?>
};

// Create a JavaScript object that holds product discounts
const productDiscount = {
    <?php foreach ($products as $product): ?>
        "<?= $product['itemName'] ?>": <?= $product['discount'] ?>,
    <?php endforeach; ?>

     
};

const productTax = {
    <?php foreach ($products as $product): ?>
        "<?=$product['itemName'] ?>": <?=$product['tax'] ?>,
        <?php endforeach; ?>
};

// Function to populate the unit price and discount when an item is selected
function updateUnitPrice(selectElement) {
    console.log("Item selected:", selectElement.value); // Debug log
    const row = selectElement.closest('tr');
    const selectedItem = selectElement.value;
    
    const unitPriceInput = row.querySelector('.unit-price');
    const discountInput = row.querySelector('.discount');
    const taxInput =row.querySelector('.tax');

    // Update the unit price input with the value from the productPrices object
    if (selectedItem && productPrices[selectedItem] !== undefined) {
        unitPriceInput.value = productPrices[selectedItem].toFixed(2);
    } else {
        unitPriceInput.value = '0.00';
    }

    // Update the discount input with the value from the productDiscount object
    if (selectedItem && productDiscount[selectedItem] !== undefined) {
        discountInput.value = productDiscount[selectedItem].toFixed(2);
    } else {
        discountInput.value = '0.00';
    }


    if (selectedItem && productTax[selectedItem] !== undefined) {
        taxInput.value = productTax[selectedItem].toFixed(2);
    }else{
        discountInput.value ='0.00';
    }




    // Recalculate subtotal whenever the unit price or discount changes
    calculateSubtotal(row);
}

// Function to recalculate the subtotal for the current row
function calculateSubtotal(row) {
    const unitPrice = parseFloat(row.querySelector('.unit-price').value) || 0;
    const quantity = parseFloat(row.querySelector('.quantity').value) || 1;
    const discount = parseFloat(row.querySelector('.discount').value) || 0;

    // Calculate the total price after applying the discount
    const discountedPrice = unitPrice - (unitPrice * (discount / 100)); // Discount as a percentage of unit price
    const subtotal = discountedPrice * quantity;

    // Update the subtotal field in the row
    row.querySelector('.subtotal').value = subtotal.toFixed(2);

    // Recalculate the total for all items
    updateTotal();
}

// Function to update the total based on all row subtotals
function updateTotal() {
    let total = 0;
    document.querySelectorAll('.subtotal').forEach(function(subtotalInput) {
        total += parseFloat(subtotalInput.value) || 0; // Add each row's subtotal
    });

    // Update the final total input field
    document.getElementById('finalTotal').value = total.toFixed(2);
}


  window.addEventListener('scroll', function() {
    const breadcrumb = document.querySelector('.breadcrumb');
    if (breadcrumb) {
      breadcrumb.style.display = 'block'; // Ensure visibility on scroll
    }
  });









    // Function to add a new row
    function addRow() {
        const table = document.getElementById('invoiceTable').getElementsByTagName('tbody')[0];
        const newRow = table.insertRow();
        newRow.innerHTML = `
            <td><select name="search" class="form-control" onchange="updateUnitPrice(this)">
                    <option value="" disabled selected>Select an Item</option>
                    <?php foreach ($products as $product): ?>
                        <option value="<?= htmlspecialchars($product['itemName'], ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars($product['itemName'], ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select></td>
            <td><input type="text" class="form-control" name="description[]"></td>
            <td><input type="number" class="form-control unit-price" name="unitPrice[]" step="0.01" value="0" oninput="calculateSubtotal(this)"></td>
            <td><input type="number" class="form-control quantity" name="quantity[]" value="1" oninput="calculateSubtotal(this)"></td>
            <td><input type="number" class="form-control discount" name="discount[]" step="0.01" value="0" oninput="calculateSubtotal(this)"></td>
            <td><input type="number" class="form-control tax" name="tax[]" step="0.01" value="0" oninput="calculateSubtotal(this)"></td>
            <td><input type="text" class="form-control subtotal" name="subtotal[]" readonly value="0"></td>
            <td class="text-center"><span class="delete-btn" onclick="deleteRow(this)">❌</span></td>
        `;
    }

    // Calculate the subtotal based on the input values
    function calculateSubtotal(element) {
        const row = element.closest('tr');
        const unitPrice = parseFloat(row.querySelector('.unit-price').value) || 0;
        const quantity = parseFloat(row.querySelector('.quantity').value) || 1;
        const discount = parseFloat(row.querySelector('.discount').value) || 0;
        const tax = parseFloat(row.querySelector('.tax').value) || 0;
        
        const subtotal = (unitPrice * quantity) - discount + tax;
        row.querySelector('.subtotal').value = subtotal.toFixed(2);
        
        updateTotal();
    }

    // Update the total based on subtotals
    function updateTotal() {
        let total = 0;
        document.querySelectorAll('.subtotal').forEach(function(subtotalInput) {
            total += parseFloat(subtotalInput.value) || 0;
        });
        document.getElementById('finalTotal').value = total.toFixed(2);
    }

    // Delete a row when the delete button is clicked
    function deleteRow(element) {
        const row = element.closest('tr');
        row.remove();
        updateTotal();
    }
</script>



<?php 
include('Footer.php');?>