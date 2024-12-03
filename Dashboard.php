cho<?php

date_default_timezone_set('Asia/Kolkata');

include('Header.php');
include('db_connect.php');
try {
    // Establish PDO connection to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    
    // Set error mode to exceptions for better debugging
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to count the total number of employees
    $query = "SELECT COUNT(*) AS total_employees FROM employee";

    // Prepare the query
    $stmt = $pdo->prepare($query);

    // Execute the query
    $stmt->execute();

    // Fetch the result
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Get the total number of employees
    $totalEmployees = $row['total_employees'];

    // Display the result (you can use this value wherever you need)
    echo "Total Employees: " . $totalEmployees;
    
} catch(PDOException $e) {
    // Handle any errors during connection or query execution
    die("Error: " . $e->getMessage());
}


try {
    // Establish PDO connection to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to count the total number of clients
    $query = "SELECT COUNT(*) AS total_clients FROM clients"; // Assuming "clients" is the table name
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    // Fetch the result
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Get the total number of clients
    $totalClients = $row['total_clients'];

} catch(PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Fetch the logged-in user's name from the session
$userName = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';

// Get the current hour
$currentHour = date("H");



// Determine the greeting based on the time of day
if ($currentHour >= 5 && $currentHour < 12) {
    $greeting = "Good Morning";
} elseif ($currentHour >= 12 && $currentHour < 18) {
    $greeting = "Good Afternoon";
} else {
    $greeting = "Good Evening";
}


// Fetch recent activities
$query = "SELECT * FROM activities ORDER BY created_at DESC LIMIT 5";
$stmt = $conn->prepare($query);
$stmt->execute();
$activities = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>



<div class=container>


    


<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <!-- Display the dynamic greeting based on time -->
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1"><?php echo $greeting . ', ' . htmlspecialchars($userName); ?>!</h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="Dashboard.php">Dashboard</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>



<div class="card-group">
    <div class="card border-right">
        <div class="card-body">
            <div class="d-flex d-lg-flex d-md-block align-items-center">
                <div>
                    <div class="d-inline-flex align-items-center">
                        <h2 class="text-dark mb-1 font-weight-medium"><?php echo $totalClients ; ?></h2>

                    </div>
                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">New Clients</h6>
                </div>
                <div class="ml-auto mt-md-3 mt-lg-0">
                    <span class="opacity-7 text-muted"><i data-feather="user-plus"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="card border-right">
        <div class="card-body">
            <div class="d-flex d-lg-flex d-md-block align-items-center">
                <div>
                    <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium"><sup
                            class="set-doller">$</sup>0</h2>
                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Earnings of Month
                    </h6>
                </div>
                <div class="ml-auto mt-md-3 mt-lg-0">
                    <span class="opacity-7 text-muted"><i data-feather="dollar-sign"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="card border-right">

    <div class="card-body">
            <div class="d-flex d-lg-flex d-md-block align-items-center">
                <div>
                    <div class="d-inline-flex align-items-center">
                        <h2 class="text-dark mb-1 font-weight-medium"><?php echo $totalEmployees; ?></h2>
         
                    </div>
                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Employess</h6>
                </div>
                <div class="ml-auto mt-md-3 mt-lg-0">
                    <span class="opacity-7 text-muted"><i data-feather="user-plus"></i></span>
                </div>
            </div>
        </div>
        </div>





</div>
<!-- *************************************************************** -->
<!-- End First Cards -->
<!-- *************************************************************** -->
<!-- *************************************************************** -->
<!-- Start Sales Charts Section -->
<!-- *************************************************************** -->
<div class="row">
    <div class="col-lg-4 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Total Sales</h4>
                <div id="campaign-v2" class="mt-2" style="height:283px; width:100%;"></div>
                <ul class="list-style-none mb-0">
                    <li>
                        <i class="fas fa-circle text-primary font-10 mr-2"></i>
                        <span class="text-muted">Direct Sales</span>
                        <span class="text-dark float-right font-weight-medium">$2346</span>
                    </li>
                    <li class="mt-3">
                        <i class="fas fa-circle text-danger font-10 mr-2"></i>
                        <span class="text-muted">Referral Sales</span>
                        <span class="text-dark float-right font-weight-medium">$2108</span>
                    </li>
                    <li class="mt-3">
                        <i class="fas fa-circle text-cyan font-10 mr-2"></i>
                        <span class="text-muted">Affiliate Sales</span>
                        <span class="text-dark float-right font-weight-medium">$1204</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Net Income</h4>
                <div class="net-income mt-4 position-relative" style="height:294px;"></div>
                <ul class="list-inline text-center mt-5 mb-2">
                    <li class="list-inline-item text-muted font-italic">Sales for this month</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Recent Activity</h4>
                <div class="mt-4 activity">
                    <div class="d-flex align-items-start border-left-line pb-3">
                        <div>
                            <a href="javascript:void(0)" class="btn btn-info btn-circle mb-2 btn-item">
                                <i data-feather="shopping-cart"></i>
                            </a>
                        </div>
                        <div class="ml-3 mt-2">
                            <h5 class="text-dark font-weight-medium mb-2">New Product Sold!</h5>
                            <p class="font-14 mb-2 text-muted">John Musa just purchased <br> Cannon 5M
                                Camera.
                            </p>
                            <span class="font-weight-light font-14 text-muted">10 Minutes Ago</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-start border-left-line pb-3">
                        <div>
                            <a href="javascript:void(0)"
                                class="btn btn-danger btn-circle mb-2 btn-item">
                                <i data-feather="message-square"></i>
                            </a>
                        </div>
                        <div class="ml-3 mt-2">
                            <h5 class="text-dark font-weight-medium mb-2">New Support Ticket</h5>
                            <p class="font-14 mb-2 text-muted">Richardson just create support <br>
                                ticket</p>
                            <span class="font-weight-light font-14 text-muted">25 Minutes Ago</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-start border-left-line">
                        <div>
                            <a href="javascript:void(0)" class="btn btn-cyan btn-circle mb-2 btn-item">
                                <i data-feather="bell"></i>
                            </a>
                        </div>
                        <div class="ml-3 mt-2">
                            <h5 class="text-dark font-weight-medium mb-2">Notification Pending Order!
                            </h5>
                            <p class="font-14 mb-2 text-muted">One Pending order from Ryne <br> Doe</p>
                            <span class="font-weight-light font-14 mb-1 d-block text-muted">2 Hours
                                Ago</span>
                            <a href="javascript:void(0)" class="font-14 border-bottom pb-1 border-info">Load More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- *************************************************************** -->
<!-- End Sales Charts Section -->
<!-- *************************************************************** -->
<!-- *************************************************************** -->
<!-- Start Location and Earnings Charts Section -->
<!-- *************************************************************** -->
<div class="row">
    <div class="col-md-6 col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <h4 class="card-title mb-0">Earning Statistics</h4>
                    <div class="ml-auto">
                        <div class="dropdown sub-dropdown">
                            <button class="btn btn-link text-muted dropdown-toggle" type="button"
                                id="dashboard" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i data-feather="more-vertical"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd1">
                                <a class="dropdown-item" href="#">Insert</a>
                                <a class="dropdown-item" href="#">Update</a>
                                <a class="dropdown-item" href="#">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pl-4 mb-5">
                    <div class="stats ct-charts position-relative" style="height: 315px;"></div>
                </div>
                <ul class="list-inline text-center mt-4 mb-0">
                    <li class="list-inline-item text-muted font-italic">Earnings for this month</li>
                </ul>
            </div>
        </div>
    </div>
  
</div>
<!-- *************************************************************** -->
<!-- End Location and Earnings Charts Section -->
<!-- *************************************************************** -->

</div>
<?php include('Footer.php'); ?>
