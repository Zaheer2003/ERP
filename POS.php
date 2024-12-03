<?php
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'cberp');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$clients = $conn->query("SELECT * FROM clients"); // Assuming your table is named 'clients'

// Fetch products from the database
$result = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Client</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> <!-- Optional for icons -->
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        .container { display: flex; height: 100vh; }
        .sidebar { width: 300px; background: #007bff; padding: 20px; color: white; display: flex; flex-direction: column; justify-content: space-between; }
        .main { flex: 1; padding: 20px; }
        .products { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 10px; }
        .product { padding: 15px; background: #e6e6e6; text-align: center; border: 1px solid #ccc; cursor: pointer; }
        .cart { margin-top: 20px; flex-grow: 1; overflow-y: auto; }
        .cart-item { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .total { font-weight: bold; margin-top: 10px; }
        .payment-btn, .client-btn { background: green; color: white; padding: 10px; border: none; cursor: pointer; width: 100%; }
        .disabled-btn { background: gray; cursor: not-allowed; }
        .client-btn { background: #007bff; margin-bottom: 10px; }
        .discount-container { display: flex; justify-content: space-between; align-items: center; margin-top: 10px; }
        .discount-type { padding: 5px; width: 45%; }
        .discount-input { padding: 5px; width: 45%; }
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); justify-content: center; align-items: center; }
        .modal-content { background: white; padding: 20px; border-radius: 8px; width: 300px; text-align: center; }
        .close { float: right; cursor: pointer; }
        .selected-client { margin-bottom: 10px; font-weight: bold; }
        /* 3-Dot Button Styling */
        .more-options-btn {
            background-color: #007bff;
            border: none;
            color: white;
            font-size: 18px;
            padding: 10px;
            cursor: pointer;
            margin-top: 20px;
            border-radius: 50%;
        }

        /* More Options Menu */
        .more-options-menu {
            display: none;
            position: absolute;
            background-color: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            top: 50px;
            left: 20px;
            width: 200px;
            border-radius: 5px;
        }

        .more-options-menu a {
            padding: 10px;
            display: block;
            color: #007bff;
            text-decoration: none;
        }

        .more-options-menu a:hover {
            background-color: #f0f0f0;
        }

        /* Hide the menu when clicked outside */
        .more-options-menu.show {
            display: block;
        }

               /* Payment Method Modal */
               #paymentMethodModal, #billModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        #paymentMethodModal .modal-content, #billModal .modal-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            text-align: center;
        }

        /* Bill Items */
        #billItems {
            list-style-type: none;
            padding: 0;
        }

        /* Close buttons for modals */
        .close {
            float: right;
            cursor: pointer;
        }
        /* Client & Product Search Bar */
        .search-bar { margin-bottom: 10px; padding: 8px; width: 100%; }
        #clientSelect, #productSearch { width: 100%; padding: 8px; }
        #productSearch { margin-top: 10px; }
        /* Time Display */
        #time { font-size: 18px; font-weight: bold; margin-top: 10px; }

    </style>
</head>
<body>

<div class="container">
    <div class="sidebar">
        <div>
            <h2>POS</h2>
            <div class="selected-client" id="selectedClientDisplay">No client selected</div>
            <button class="client-btn" id="selectClientBtn">Select Client</button>
            <div class="cart" id="cart">
                <p>No items in cart.</p>
            </div>
        </div>
        <div>
            <p class="total" id="total">Total: Rs. 0.00</p>
            <!-- Discount Type & Discount Input -->
            <div class="discount-container">
                <select id="discountType" class="discount-type">
                    <option value="percentage">Discount (%)</option>
                    <option value="fixed">Fixed Amount</option>
                </select>
                <input type="number" id="discountInput" class="discount-input" placeholder="Enter discount" />
            </div>
            <button class="payment-btn disabled-btn" id="paymentBtn" disabled>Payment</button>
            <!-- 3-Dot Button -->
            <button class="more-options-btn" id="moreOptionsBtn"><i class="fas fa-ellipsis-h"></i></button>
            <!-- More Options Menu -->
            <div class="more-options-menu" id="moreOptionsMenu">
                <a href="#" id="discardOrder">Discard Order</a>
                <a href="#" id="holdOrder">Hold</a>
                <a href="#" id="removeAllItems">Remove All Items</a>
                <a href="#" id="invoiceDetails">Invoice Details</a>
                <a href="#" id="deliveryOption">Delivery Option</a>
                <a href="#" id="back">Back</a>
            </div>
        </div>
    </div>
    <div class="main">
        <h2>Products</h2>
        <input type="text" id="productSearch" class="search-bar" placeholder="Search products..." />
        <div class="products" id="products">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="product" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['itemName']; ?>" data-price="<?php echo $row['sellingPrice']; ?>">
                    <p><?php echo $row['itemName']; ?></p>
                    <p>Rs. <?php echo $row['sellingPrice']; ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>


<!-- Modal for Client Selection -->
<div class="modal" id="clientModal">
    <div class="modal-content">
        <span class="close" id="closeModal">&times;</span>
        <h2>Select a Client</h2>
        <input type="text" id="clientSearch" class="search-bar" placeholder="Search clients..." />
        <select id="clientSelect">
            <option value="">-- Select Client --</option>
            <?php while ($client = $clients->fetch_assoc()): ?>
                <option value="<?php echo htmlspecialchars($client['id']); ?>">
                    <?php echo htmlspecialchars($client['name']); ?>
                </option>
            <?php endwhile; ?>
        </select>
        <button class="client-btn" id="confirmClientBtn">Confirm</button>
    </div>
</div>



<!-- Modal for Payment Method Selection -->
<div class="modal" id="paymentMethodModal">
    <div class="modal-content">
        <span class="close" id="closePaymentMethodModal">&times;</span>
        <h2>Select Payment Method</h2>
        <select id="paymentMethodSelect">
            <option value="cash">Cash</option>
            <option value="credit">Credit</option>
        </select>
        <button class="client-btn" id="confirmPaymentMethodBtn">Confirm</button>
    </div>
</div>

<!-- Modal for Displaying the Bill -->
<div class="modal" id="billModal">
    <div class="modal-content">
        <span class="close" id="closeBillModal">&times;</span>
        <h2>Bill Details</h2>
        <p><strong>Client:</strong> <span id="billClient"></span></p>
        <p><strong>Items:</strong></p>
        <ul id="billItems"></ul>
        <p><strong>Total:</strong> Rs. <span id="billTotal"></span></p>
        <p><strong>Payment Method:</strong> <span id="billPaymentMethod"></span></p>
        <button class="client-btn" id="closeBillBtn">Close</button>
    </div>
</div>

<!-- Time Display -->
<div id="time"></div>



<script>
   const products = document.querySelectorAll('.product');
    const cart = document.getElementById('cart');
    const totalDisplay = document.getElementById('total');
    const paymentBtn = document.getElementById('paymentBtn');
    const discountInput = document.getElementById('discountInput');
    const discountTypeSelect = document.getElementById('discountType');
    const selectClientBtn = document.getElementById('selectClientBtn');
    const clientModal = document.getElementById('clientModal');
    const closeModal = document.getElementById('closeModal');
    const confirmClientBtn = document.getElementById('confirmClientBtn');
    const clientSelect = document.getElementById('clientSelect');
    const selectedClientDisplay = document.getElementById('selectedClientDisplay');

    let total = 0;
    const cartItems = [];
    let selectedClient = '';
    let discount = 0;
    let discountType = 'percentage'; // Default discount type

    // Handle product click
    products.forEach(product => {
        product.addEventListener('click', () => {
            const name = product.dataset.name;
            const price = parseFloat(product.dataset.price);

            cartItems.push({ name, price });
            updateCart();
        });
    });

    // Update the cart
    function updateCart() {
        cart.innerHTML = '';
        total = 0;
        cartItems.forEach(item => {
            total += item.price;
            const cartItem = document.createElement('div');
            cartItem.classList.add('cart-item');
            cartItem.innerHTML = `<span>${item.name}</span><span>Rs. ${item.price}</span>`;
            cart.appendChild(cartItem);
        });

        // Apply discount
        if (discountType === 'percentage') {
            total -= (total * discount) / 100;
        } else if (discountType === 'fixed') {
            total -= discount;
        }

        totalDisplay.textContent = `Total: Rs. ${total.toFixed(2)}`;
        paymentBtn.disabled = total === 0 || !selectedClient; // Enable payment button only if items are in cart and client is selected
    }

    // Discount input change
    discountInput.addEventListener('input', () => {
        discount = parseFloat(discountInput.value) || 0;
        updateCart();
    });

    // Discount type change
    discountTypeSelect.addEventListener('change', () => {
        discountType = discountTypeSelect.value;
        updateCart();
    });

    // Open client selection modal
    selectClientBtn.addEventListener('click', () => {
        clientModal.style.display = 'flex';
    });

    // Close client modal
    closeModal.addEventListener('click', () => {
        clientModal.style.display = 'none';
    });

    // Confirm client selection
    confirmClientBtn.addEventListener('click', () => {
        selectedClient = clientSelect.value;
        if (selectedClient) {
            selectedClientDisplay.textContent = `Selected Client: ${clientSelect.options[clientSelect.selectedIndex].text}`;
            clientModal.style.display = 'none';
        }
    });

    // Open payment method selection modal
    paymentBtn.addEventListener('click', () => {
        if (selectedClient) {
            document.getElementById('paymentMethodModal').style.display = 'flex';
        }
    });

    // Close payment method modal
    document.getElementById('closePaymentMethodModal').addEventListener('click', () => {
        document.getElementById('paymentMethodModal').style.display = 'none';
    });

    // Confirm payment method and show bill
    document.getElementById('confirmPaymentMethodBtn').addEventListener('click', () => {
        const paymentMethod = document.getElementById('paymentMethodSelect').value;
        const billModal = document.getElementById('billModal');

        // Display bill info
        document.getElementById('billClient').textContent = clientSelect.options[clientSelect.selectedIndex].text;
        document.getElementById('billItems').innerHTML = '';
        cartItems.forEach(item => {
            const billItem = document.createElement('li');
            billItem.textContent = `${item.name}: Rs. ${item.price}`;
            document.getElementById('billItems').appendChild(billItem);
        });
        document.getElementById('billTotal').textContent = total.toFixed(2);
        document.getElementById('billPaymentMethod').textContent = paymentMethod;

        // Show the bill modal
        billModal.style.display = 'flex';
    });

    // Close the bill modal
    document.getElementById('closeBillModal').addEventListener('click', () => {
        document.getElementById('billModal').style.display = 'none';
        // Reset for new transaction
        cartItems.length = 0;
        updateCart();
        selectedClientDisplay.textContent = 'No client selected';
        discountInput.value = '';
    });

    // Close bill modal and reset everything
    document.getElementById('closeBillBtn').addEventListener('click', () => {
        document.getElementById('billModal').style.display = 'none';
        // Reset for new transaction
        cartItems.length = 0;
        updateCart();
        selectedClientDisplay.textContent = 'No client selected';
        discountInput.value = '';
    });

</script>

</body>
</html>
