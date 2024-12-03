<?php
// Database connection and initialization
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cberp";  // Replace with your actual database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define variables for handling form input data (with default values)
$invoiceNumber = "000001";  // Static invoice number
$invoiceDate = "";
$paymentTerms = "";
$discount = 0;
$adjustment = 0;
$notes = "";

// Fetch clients from the database
$clients = [];
$sqlClients = "SELECT id, name FROM clients";
$resultClients = $conn->query($sqlClients);
if ($resultClients->num_rows > 0) {
    while ($row = $resultClients->fetch_assoc()) {
        $clients[] = $row;
    }
}

// Fetch products for the invoice items
$products = [];
$sqlProducts = "SELECT id, itemName, initialStock, sellingPrice FROM products";
$resultProducts = $conn->query($sqlProducts);
if ($resultProducts->num_rows > 0) {
    while ($row = $resultProducts->fetch_assoc()) {
        $products[] = $row;
    }
}

// Handle form submission logic (handle POST data)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate POST data
    $invoiceDate = isset($_POST['invoiceDate']) ? $_POST['invoiceDate'] : '';
    $paymentTerms = isset($_POST['paymentTerms']) ? $_POST['paymentTerms'] : '';
    $discount = isset($_POST['discount']) ? floatval($_POST['discount']) : 0;
    $adjustment = isset($_POST['adjustment']) ? floatval($_POST['adjustment']) : 0;
    $notes = isset($_POST['notes']) ? $_POST['notes'] : '';
    $clientId = isset($_POST['client']) ? (int)$_POST['client'] : 0;
    $invoiceItems = isset($_POST['items']) ? $_POST['items'] : [];

    // If no client is selected, exit early
    if (!$clientId) {
        echo "Please select a client.";
        exit();
    }

    // Retrieve client details (optional)
    $sqlClientDetails = "SELECT name FROM clients WHERE id = ?";
    $stmtClientDetails = $conn->prepare($sqlClientDetails);
    $stmtClientDetails->bind_param("i", $clientId);
    $stmtClientDetails->execute();
    $resultClientDetails = $stmtClientDetails->get_result();
    $client = $resultClientDetails->fetch_assoc();
    $clientName = $client['name'];

    // Create the Invoice and Insert into database
    $invoiceTotal = 0; // Initialize invoice total
    foreach ($invoiceItems as $item) {
        $productId = isset($item['product_id']) ? (int)$item['product_id'] : 0;
        $quantity = isset($item['quantity']) ? (int)$item['quantity'] : 0;
        $unitPrice = isset($item['unit_price']) ? floatval($item['unit_price']) : 0;

        // Validate item data
        if ($productId && $quantity > 0 && $unitPrice > 0) {
            $subtotal = $unitPrice * $quantity;
            $invoiceTotal += $subtotal;

            // Update stock in the product table
            $sqlUpdateStock = "UPDATE products SET initialStock = initialStock - ? WHERE id = ?";
            $stmtUpdateStock = $conn->prepare($sqlUpdateStock);
            $stmtUpdateStock->bind_param("ii", $quantity, $productId);
            $stmtUpdateStock->execute();

            // Insert invoice item into database
            $sqlInsertInvoiceItem = "INSERT INTO invoice_items (invoice_number, product_id, quantity, price) VALUES (?, ?, ?, ?)";
            $stmtInsertInvoiceItem = $conn->prepare($sqlInsertInvoiceItem);
            $stmtInsertInvoiceItem->bind_param("siii", $invoiceNumber, $productId, $quantity, $unitPrice);
            $stmtInsertInvoiceItem->execute();
        }
    }

    // Apply discount and adjustment
    if ($discount > 0) {
        $invoiceTotal -= $discount;
    }
    if ($adjustment > 0) {
        $invoiceTotal += $adjustment;
    }

    // Generate PDF Invoice
    require_once('tcpdf/tcpdf.php'); // Include TCPDF library

    // Create new PDF document
    $pdf = new TCPDF();
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', '', 12);

    // Add invoice heading
    $pdf->Cell(0, 10, 'Invoice - ' . $invoiceNumber, 0, 1, 'C');

    // Add client name and invoice date
    $pdf->Cell(0, 10, 'Client: ' . $clientName, 0, 1);
    $pdf->Cell(0, 10, 'Invoice Date: ' . $invoiceDate, 0, 1);
    $pdf->Cell(0, 10, 'Payment Terms: ' . $paymentTerms . ' days', 0, 1);
    $pdf->Cell(0, 10, 'Discount: ' . $discount, 0, 1);
    $pdf->Cell(0, 10, 'Adjustment: ' . $adjustment, 0, 1);
    $pdf->Cell(0, 10, 'Notes/Terms: ' . $notes, 0, 1);

    // Table for invoice items (example)
    $pdf->Cell(40, 10, 'Item', 1);
    $pdf->Cell(40, 10, 'Description', 1);
    $pdf->Cell(30, 10, 'Unit Price', 1);
    $pdf->Cell(30, 10, 'Quantity', 1);
    $pdf->Cell(30, 10, 'Subtotal', 1);
    $pdf->Ln();

    // Loop through invoice items and print in table
    foreach ($invoiceItems as $item) {
        $productId = $item['product_id'];
        $quantity = $item['quantity'];
        $unitPrice = $item['unit_price'];
        $subtotal = $unitPrice * $quantity;

        // Fetch product name and description
        $sqlProductDetails = "SELECT itemName, description FROM products WHERE id = ?";
        $stmtProductDetails = $conn->prepare($sqlProductDetails);
        $stmtProductDetails->bind_param("i", $productId);
        $stmtProductDetails->execute();
        $resultProductDetails = $stmtProductDetails->get_result();
        $product = $resultProductDetails->fetch_assoc();
        $itemName = $product['itemName'];
        $itemDescription = $product['description'];

        // Add item to the table
        $pdf->Cell(40, 10, $itemName, 1);
        $pdf->Cell(40, 10, $itemDescription, 1);
        $pdf->Cell(30, 10, $unitPrice, 1);
        $pdf->Cell(30, 10, $quantity, 1);
        $pdf->Cell(30, 10, $subtotal, 1);
        $pdf->Ln();
    }

    // Add total to the invoice
    $pdf->Cell(140, 10, 'Total:', 1);
    $pdf->Cell(30, 10, $invoiceTotal, 1, 1, 'C');

    // Output the PDF (to browser)
    $pdf->Output('invoice_' . $invoiceNumber . '.pdf', 'I');
}
?>
