<?php 
include('Header.php'); 
?>

<div class="container">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <!-- Button with FontAwesome icon that links to AddWarehouses.php -->
                <a href="AddWarehouses.php" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i> Add Warehouse
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Section to Display Existing Warehouses -->
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3>Warehouses</h3>
                </div>
                <div class="card-body">
                    <?php
                    // Database connection (update with your credentials)
                    $host = 'localhost';
                    $username = 'root';
                    $password = '';
                    $dbname = 'cberp'; // Replace with your actual database name

                    // Create connection
                    $conn = new mysqli($host, $username, $password, $dbname);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Query to fetch warehouses
                    $sql = "SELECT * FROM warehouses"; // Replace 'warehouses' with your actual table name
                    $result = $conn->query($sql);

                    // Check if there are any warehouses in the database
                    if ($result->num_rows > 0) {
                        // Loop through and display each warehouse
                        echo '<table class="table">';
                        echo '<thead><tr><th>#</th><th>Name</th><th>Location</th><th>Actions</th></tr></thead>';
                        echo '<tbody>';
                        while($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row['id'] . '</td>'; // Replace 'id' with your primary key column
                            echo '<td>' . $row['name'] . '</td>'; // Replace 'name' with the warehouse name column
                            echo '<td>' . $row['location'] . '</td>'; // Replace 'location' with the warehouse location column
                            echo '<td><a href="editWarehouse.php?id=' . $row['id'] . '" class="btn btn-warning btn-sm">Edit</a> <a href="deleteWarehouse.php?id=' . $row['id'] . '" class="btn btn-danger btn-sm">Delete</a></td>';
                            echo '</tr>';
                        }
                        echo '</tbody>';
                        echo '</table>';
                    } else {
                        echo '<p>No warehouses found.</p>';
                    }

                    // Close the connection
                    $conn->close();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Include the footer
include 'Footer.php';
?>
