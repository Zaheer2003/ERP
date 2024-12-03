<?php 
include('Header.php'); 
?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f4f7;
        margin: 0; /* Remove default margin */
        display: flex;
        flex-direction: column; /* Stack elements vertically */
        min-height: 100vh; /* Ensure full viewport height */
    }
    .container {
        flex: 1; /* Takes up remaining vertical space */
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        width: 90%;
        max-width: 1000px;
        padding: 20px;
        box-sizing: border-box;
        margin: 20px auto; /* Center container and add top-bottom margin */
    }
    .card {
        background-color: white;
        padding: 30px;
        text-align: center;
        border-radius: 12px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
        text-decoration: none; /* Remove underline from links */
        color: inherit; /* Inherit text color */
    }
    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
    }
    .card i {
        font-size: 48px;
        color: #3e50b4;
        transition: color 0.3s ease;
    }
    .card:hover i {
        color: #1a237e;
    }
    .card h3 {
        margin-top: 15px;
        color: #333;
        font-size: 20px;
    }
</style>

<div class="container mt-5">
    <?php 
    // Array to dynamically generate cards
    $cards = [
        ["icon" => "fas fa-cogs", "title" => "General Invoice/Estimate Settings", "link" => "settings.php"],
        ["icon" => "fas fa-file-invoice", "title" => "Invoice/Estimate Layouts", "link" => "layouts.php"],
        ["icon" => "fas fa-percent", "title" => "Offers", "link" => "offers.php"],
        ["icon" => "fas fa-magic", "title" => "Custom Fields", "link" => "custom_fields.php"],
        ["icon" => "fas fa-shipping-fast", "title" => "Shipping Options", "link" => "shipping.php"],
        ["icon" => "fas fa-network-wired", "title" => "Order Sources", "link" => "orders.php"]
    ];

    // Generate cards dynamically
    foreach ($cards as $card) {
        echo "<a href='{$card['link']}' class='card'>
                <i class='{$card['icon']}' aria-hidden='true'></i>
                <h3>{$card['title']}</h3>
              </a>";
    }
    ?>
</div>

<?php 
include('Footer.php'); 
?>
