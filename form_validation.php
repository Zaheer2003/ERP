<?php

// Validate form data
function validate_form($data) {
    $errors = [];

    // Item Name
    if (empty($data['itemName'])) {
        $errors['itemName'] = 'Item name is required.';
    }

    // Item SKU (if manually entered or if auto-generated, handle accordingly)
    if (empty($data['itemSKU']) || $data['itemSKU'] === 'Auto-generated') {
        $errors['itemSKU'] = 'Item SKU must be provided.';
    }

    // Description
    if (empty($data['description'])) {
        $errors['description'] = 'Description is required.';
    }

    // Purchase Price
    if (empty($data['purchasePrice']) || !is_numeric($data['purchasePrice']) || $data['purchasePrice'] <= 0) {
        $errors['purchasePrice'] = 'Valid purchase price is required.';
    }

    // Selling Price
    if (empty($data['sellingPrice']) || !is_numeric($data['sellingPrice']) || $data['sellingPrice'] <= 0) {
        $errors['sellingPrice'] = 'Valid selling price is required.';
    }

    // Minimum Price
    if (!empty($data['minimumPrice']) && (!is_numeric($data['minimumPrice']) || $data['minimumPrice'] <= 0)) {
        $errors['minimumPrice'] = 'Minimum price must be a valid positive number.';
    }

    // Discount (if applicable)
    if (!empty($data['discount']) && (!is_numeric($data['discount']) || $data['discount'] < 0 || $data['discount'] > 100)) {
        $errors['discount'] = 'Discount must be a number between 0 and 100.';
    }

    // Tax
    if (empty($data['tax'])) {
        $errors['tax'] = 'Tax is required.';
    }

    // Profit Margin
    if (!empty($data['profitMargin']) && (!is_numeric($data['profitMargin']) || $data['profitMargin'] < 0)) {
        $errors['profitMargin'] = 'Profit margin must be a valid non-negative number.';
    }

    // Inventory Management (if "Track Stock" is enabled)
    if (isset($data['trackStock']) && $data['trackStock']) {
        if (empty($data['initialStock']) || !is_numeric($data['initialStock']) || $data['initialStock'] < 0) {
            $errors['initialStock'] = 'Valid initial stock level is required.';
        }

        if (empty($data['lowStockThreshold']) || !is_numeric($data['lowStockThreshold']) || $data['lowStockThreshold'] < 0) {
            $errors['lowStockThreshold'] = 'Low stock threshold must be a valid non-negative number.';
        }
    }

    return $errors;
}

// Validate uploaded photo (if any)
function validate_photo($file) {
    $errors = [];
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $max_size = 5 * 1024 * 1024; // 5MB

    if ($file['error'] != 0) {
        $errors[] = 'Error uploading the file.';
    }

    if (!in_array($file['type'], $allowed_types)) {
        $errors[] = 'Only JPG, PNG, and GIF files are allowed.';
    }

    if ($file['size'] > $max_size) {
        $errors[] = 'The file size exceeds the 5MB limit.';
    }

    return $errors;
}

// Example function to validate if SKU already exists in the database
function check_sku_exists($sku) {
    global $conn; // Assume $conn is your database connection
    
    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT COUNT(*) FROM products WHERE sku = ?");
    if ($stmt === false) {
        // Error in preparing the statement
        die('MySQL prepare error: ' . $conn->error);
    }

    // Bind the SKU parameter to the query
    $stmt->bind_param("s", $sku);

    // Execute the query
    $stmt->execute();

    // Bind the result variable to fetch the count
    $stmt->bind_result($count);
    
    // Check if result binding was successful
    if ($stmt->fetch()) {
        // Return true if SKU exists (count > 0)
        return $count > 0;
    } else {
        // If fetching failed, handle the error
        die('Error fetching result: ' . $stmt->error);
    }

    // Close the statement
    $stmt->close();
}

?>
