<?php
// Include the TCPDF library
require_once('TCPDF/tcpdf.php'); // Ensure the path is correct

// Function to validate POST data
function validateInvoiceData($data) {
    if (empty($data['client']) || empty($data['invoiceDate']) || empty($data['item']) || count($data['item']) == 0) {
        die('Error: Missing invoice data. Please fill all fields.');
    }

    $arrayLengths = [
        count($data['item']),
        count($data['description']),
        count($data['unitPrice']),
        count($data['quantity']),
        count($data['discount']),
        count($data['tax']),
        count($data['subtotal'])
    ];
    if (count(array_unique($arrayLengths)) !== 1) {
        die('Error: Inconsistent item data. All item arrays must have the same number of elements.');
    }

    return true;
}

// Function to sanitize user inputs
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// Retrieve POST data from the form
$client = sanitizeInput($_POST['client'] ?? '');
$invoiceDate = sanitizeInput($_POST['invoiceDate'] ?? '');
$items = $_POST['item'] ?? [];
$descriptions = $_POST['description'] ?? [];
$unitPrices = $_POST['unitPrice'] ?? [];
$quantities = $_POST['quantity'] ?? [];
$discounts = $_POST['discount'] ?? [];
$taxes = $_POST['tax'] ?? [];
$subtotals = $_POST['subtotal'] ?? [];

// Validate the data
validateInvoiceData($_POST);

// Initialize TCPDF object
$pdf = new TCPDF();
$pdf->SetAuthor('Your Company Name');
$pdf->SetTitle('Invoice');
$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(TRUE, 15);
$pdf->AddPage();

// Set title
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, 'Invoice', 0, 1, 'C');

// Client and Date details
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(100, 10, 'Client: ' . $client, 0, 1);
$pdf->Cell(100, 10, 'Invoice Date: ' . $invoiceDate, 0, 1);
$pdf->Ln(10);

// Table Header
$pdf->SetFont('helvetica', 'B', 12);
$header = ['Item', 'Description', 'Unit Price', 'Quantity', 'Discount', 'Tax', 'Subtotal'];
$widths = [30, 50, 30, 30, 30, 30, 30];

// Alignments for each column
$alignments = ['C', 'L', 'C', 'C', 'C', 'C', 'C'];

// Print header cells
foreach ($header as $i => $col) {
    $pdf->Cell($widths[$i], 10, $col, 1, 0, 'C');
}
$pdf->Ln();  // Move to the next row

// Table Rows
$pdf->SetFont('helvetica', '', 12);
$totalAmount = 0;

foreach ($items as $i => $item) {
    $description = sanitizeInput($descriptions[$i]);
    $unitPrice = (float)$unitPrices[$i];
    $quantity = (int)$quantities[$i];
    $discount = (float)$discounts[$i];
    $tax = (float)$taxes[$i];
    $subtotal = (float)$subtotals[$i];

    // Add row cells with dynamic alignment
    $pdf->Cell($widths[0], 10, sanitizeInput($item), 1, 0, $alignments[0]);
    $pdf->Cell($widths[1], 10, $description, 1, 0, $alignments[1]);
    $pdf->Cell($widths[2], 10, '$' . number_format($unitPrice, 2), 1, 0, $alignments[2]);
    $pdf->Cell($widths[3], 10, $quantity, 1, 0, $alignments[3]);
    $pdf->Cell($widths[4], 10, $discount . '%', 1, 0, $alignments[4]);
    $pdf->Cell($widths[5], 10, $tax . '%', 1, 0, $alignments[5]);
    $pdf->Cell($widths[6], 10, '$' . number_format($subtotal, 2), 1, 1, $alignments[6]);

    $totalAmount += $subtotal;
}

// Total Section
$pdf->Ln(10);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(array_sum($widths) - 30, 10, 'Total Amount', 1, 0, 'C');
$pdf->Cell(30, 10, '$' . number_format($totalAmount, 2), 1, 1, 'C');

// Ensure 'invoices' directory exists
$invoiceDir = __DIR__ . '/invoices';
if (!file_exists($invoiceDir)) {
    mkdir($invoiceDir, 0755, true);  // Create the directory with proper permissions
}

// Save the PDF to the 'invoices' folder
$pdfOutputPath = $invoiceDir . '/invoice_' . time() . '.pdf';
$pdf->Output($pdfOutputPath, 'F');

// Confirm generation and provide download link
if (file_exists($pdfOutputPath)) {
    echo '<h2>Invoice Generated Successfully!</h2>';
    echo '<a href="invoices/' . basename($pdfOutputPath) . '" target="_blank">Download Invoice PDF</a>';
} else {
    echo '<h2>Error: Invoice could not be generated.</h2>';
}
?>
