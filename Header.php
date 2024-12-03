<!--Header Php-->
<?php
session_start();

// Redirect to login if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");  // Redirect to the login page
    exit();
}

$username = htmlspecialchars($_SESSION['username']);  // Sanitize to prevent XSS


if (isset($_SESSION['role'])) {
    $user_role = $_SESSION['role']; // Fetch the role from the session
} else {
    // Optionally, set a default role if not found (e.g., 'Guest' or 'Employee')
    $user_role = 'Employee'; // Default value or redirect to login page
}

// Check if the user data exists in the session
if (isset($_SESSION['users']) && !empty($_SESSION['users'])) {
    $user = $_SESSION['user']; // Assign user data from session
} else {
    $user = null; // No user logged in, set $user to null
}

// If user is null, you may want to redirect to login or show a default image
if ($user !== null && isset($user['userPicture'])) {
    $imagePath = 'uploads/' . $user['userPicture']; // Dynamically get the image path
} else {
    // Set default image path if no user picture exists
    $imagePath = 'uploads/default.jpg';
}

?>


<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!--- Google Map API --->

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="ERPAssest/assets/images/favicon.png">
    <title><?php echo isset($pageTitle) ? $pageTitle : "Admin"; ?></title>

    <!-- Custom CSS -->
    <link href="../ERPAssest/assets/extra-libs/c3/c3.min.css" rel="stylesheet">
    <link href="../ERPAssest/assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <link href="../ERPAssest/assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>

    <link href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css" rel="stylesheet"/>
    <script src="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css" ></script>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">





    <!-- Custom CSS -->
    <link href="../ERPAssest/dist/css/style.min.css" rel="stylesheet">

    <!-- Data Table -->
    <link href="../ERPAssest/datatables/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="../ERPAssest/datatables/css/responsive.bootstrap4.min.css" rel="stylesheet" />
    <link href="../ERPAssest/datatables/css/icon-font.min.css" rel="stylesheet" />

    <script src="../ERPAssest/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap JS (for collapsible functionality) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="../ERPAssest/assets/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../ERPAssest/assets/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../ERPAssest/assets/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../ERPAssest/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../ERPAssest/assets/libs/perfect-scrollbar/perfect-scrollbar.css" />

 

    <!-- Page CSS -->
  

    <!-- Helpers -->
    <script src="../ERPAssest/assets/js/helpers.js"></script>
    <!-- Template customizer & Theme config files -->
    <script src="../ERPAssest/assets/js/config.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>


<div class="preloader">
     <div class="lds-ripple">
         <div class="lds-pos"></div>
         <div class="lds-pos"></div>
     </div>
 </div>
 <!-- ============================================================== -->
 <!-- Main wrapper - style you can find in pages.scss -->
 <!-- ============================================================== -->
 <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
     data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
     <!-- ============================================================== -->
     <!-- Topbar header - style you can find in pages.scss -->
     <!-- ============================================================== -->
     <header class="topbar" data-navbarbg="skin6">
         <nav class="navbar top-navbar navbar-expand-md">
             <div class="navbar-header" data-logobg="skin6">
                 <!-- This is for the sidebar toggle which is visible on mobile only -->
                 <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                         class="ti-menu ti-close"></i></a>
                 <!-- ============================================================== -->
                 <!-- Logo -->
                 <!-- ============================================================== -->
                 <div class="navbar-brand">
                     <!-- Logo icon -->
                     <a href="index.html">
                         <b class="logo-icon">
                             <!-- Dark Logo icon -->
                           <!-- <img src="../admintemplate/assets/images/Logo-new.jpg"  alt="homepage" class="dark-logo" />-->
                             <!-- Light Logo icon -->
                             <!--img src="../admintemplate/assets/images/logo-icon.png" alt="homepage" class="light-logo" /-->
                         </b>
                         <!--End Logo icon -->
                         <!-- Logo text -->
                         <span class="logo-text">
                             <!-- dark Logo text -->
                             <!--img src="../admintemplate/assets/images/logo-text.png" alt="homepage" class="dark-logo" /-->
                             <!-- Light Logo text -->
                             <!--img src="../admintemplate/assets/images/logo-light-text.png" class="light-logo" alt="homepage" /-->
                         </span>
                     </a>
                 </div>
                 <!-- ============================================================== -->
                 <!-- End Logo -->
                 <!-- ============================================================== -->
                 <!-- ============================================================== -->
                 <!-- Toggle which is visible on mobile only -->
                 <!-- ============================================================== -->
                 <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                     data-toggle="collapse" data-target="#navbarSupportedContent"
                     aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                         class="ti-more"></i></a>
             </div>
             <!-- ============================================================== -->
             <!-- End Logo -->
             <!-- ============================================================== -->
             <div class="navbar-collapse collapse" id="navbarSupportedContent">
    <!-- ============================================================== -->
    <!-- toggle and nav items -->
    <!-- ============================================================== -->
 
    <ul class="navbar-nav float-left mr-auto ml-3 pl-1">
    
</ul>





                
                 <!-- ============================================================== -->
                 <!-- Right side toggle and nav items -->
                 <!-- ============================================================== -->
                 <ul class="navbar-nav float-right">
                     <!-- ============================================================== -->
                    
                     <!-- User profile and search -->
                     <!-- ============================================================== -->
                     <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                   <?php 
            $imagePath = !empty($user['userPicture']) ? 'uploads/' . $user['userPicture'] : 'uploads/default.jpg';
            echo '<img src="' . $imagePath . '" alt="user" class="rounded-circle" width="40">';
            ?>
                    <span class="ml-2 d-none d-lg-inline-block">
                        <span>Hello,</span>
                        <span class="text-dark"><?php echo $username; ?></span>
                        <i data-feather="chevron-down" class="svg-icon"></i>
                    </span>
                </a>
                         <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                             <a class="dropdown-item" href="Main.php"><i data-feather="user"
                                     class="svg-icon mr-2 ml-1"></i>
                                 My Profile</a>
                             <a class="dropdown-item" href="ASetting.php"><i data-feather="credit-card"
                                     class="svg-icon mr-2 ml-1"></i>
                                 Account Setting</a>
                             <div class="dropdown-divider"></div>
                             <a class="dropdown-item" href="index.php"><i data-feather="power"
                                     class="svg-icon mr-2 ml-1"></i>
                                 Logout</a>
                         </div>
                     </li>
                     <!-- ============================================================== -->
                     <!-- User profile and search -->
                     <!-- ============================================================== -->
                 </ul>
             </div>
         </nav>
     </header>
     <!-- ============================================================== -->
     <!-- End Topbar header -->
     <!-- ============================================================== -->
     <!-- ============================================================== -->
     <!-- Left Sidebar - style you can find in sidebar.scss  -->
     <!-- ============================================================== -->
     <aside class="left-sidebar" data-sidebarbg="skin6">
         <!-- Sidebar scroll-->
         <div class="scroll-sidebar" data-sidebarbg="skin6">
             <!-- Sidebar navigation-->
             <nav class="sidebar-nav">
                 <ul id="sidebarnav">
                     <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="Dashboard.php"
                             aria-expanded="false"><i data-feather="home" class="feather-icon"></i><span
                                 class="hide-menu">Dashboard</span></a></li>

                                 
                   

                     <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                             aria-expanded="false"><i data-feather="file-text" class="feather-icon"></i><span
                                 class="hide-menu">Sales </span></a>
                         <ul aria-expanded="false" class="collapse  first-level base-level-line">
                        
                             <li class="sidebar-item"><a href="InvoiceForm.php" class="sidebar-link"><span
                                         class="hide-menu"> Create Invoice
                                     </span></a>
                             </li>
                        

                             <?php if ($user_role == 'Manager'): ?>
                          

                             <li class="sidebar-item"><a href="Main.php" class="sidebar-link"><span
                                         class="hide-menu"> Manage Invoice
                                     </span></a>
                             </li>
                             <li class="sidebar-item"><a href="Main.php" class="sidebar-link"><span
                                         class="hide-menu"> Client Payments
                                     </span></a>
                             </li>


                             <li class="sidebar-item"><a href="invoicesetting.php" class="sidebar-link"><span
                                         class="hide-menu"> Sales Settings
                                     </span></a>
                             </li>

                             <?php endif; ?>



                           
                 



                         </ul>
                     </li>
                     <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                             aria-expanded="false"><i data-feather="users" class="feather-icon"></i><span
                                 class="hide-menu">Clients </span></a>
                         <ul aria-expanded="false" class="collapse  first-level base-level-line">
                             <li class="sidebar-item"><a href="AddClients.php" class="sidebar-link"><span
                                         class="hide-menu">  Add New Clients
                                     </span></a>
                             </li>

                             <?php if ($user_role == 'Manager'): ?>
                             <li class="sidebar-item"><a href="ManageClients.php" class="sidebar-link"><span
                                         class="hide-menu"> Manage Clients
                                     </span></a>
                             </li>
                             <li class="sidebar-item"><a href="Main.php" class="sidebar-link"><span
                                         class="hide-menu">
                                         Contact List
                                     </span></a>
                             </li>
                             <?php endif; ?>
                         
                         </ul>
                     </li>
                     <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                             aria-expanded="false"><i data-feather="box" class="feather-icon"></i><span
                                 class="hide-menu">Inventory </span></a>
                         <ul aria-expanded="false" class="collapse  first-level base-level-line">


                             <li class="sidebar-item"><a href="AddProducts.php" class="sidebar-link"><span
                                         class="hide-menu">  Add Product
                                     </span></a>
                                     </li>

                                     <?php if ($user_role == 'Manager'): ?>

                                 <li class="sidebar-item"><a href="ManageProducts.php" class="sidebar-link"><span
                                      class="hide-menu">  Manage Products
                                      </span></a>
                                      </li>

                                      <?php endif; ?>

                                      <li class="sidebar-item"><a href="Main.php" class="sidebar-link"><span
                                      class="hide-menu">  Add Services
                                      </span></a>
                                      </li>


                             </li>
                             <li class="sidebar-item"><a href="Main.php" class="sidebar-link"><span
                                         class="hide-menu"> Price List
                                     </span></a>
                             </li>
                             <li class="sidebar-item"><a href="Warehouses.php" class="sidebar-link"><span
                                         class="hide-menu">
                                         Warehouses
                                     </span></a>
                             </li>
                         </ul>
                     </li>
                     <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                             aria-expanded="false"><i data-feather="truck" class="feather-icon"></i><span
                                 class="hide-menu">Purchases </span></a>
                         <ul aria-expanded="false" class="collapse  first-level base-level-line">
                             <li class="sidebar-item"><a href="Main.php" class="sidebar-link"><span
                                         class="hide-menu"> Purchase Invoices
                                     </span></a>
                             </li>
                             <li class="sidebar-item"><a href="Main.php" class="sidebar-link"><span
                                         class="hide-menu"> Purchase Refunds </span></a>
                             </li>

                             <li class="sidebar-item"><a href="Main.php" class="sidebar-link"><span
                                         class="hide-menu"> Manage Supplier </span></a></li>
                             <li class="sidebar-item"><a href="ui-notification.html" class="sidebar-link"><span
                                         class="hide-menu">Supplier Payment</span></a></li>
                             
                         </ul>
                     </li>

                             <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                aria-expanded="false"><i data-feather="dollar-sign" class="feather-icon"></i><span
                                  class="hide-menu">Finance </span></a>

                       <ul aria-expanded="false" class="collapse  first-level base-level-line">
                         <li class="sidebar-item"><a href="Main.php" class="sidebar-link"><span
                             class="hide-menu"> Expences
                            </span></a>
                          </li>
                        <li class="sidebar-item"><a href="Main.php" class="sidebar-link"><span
                          class="hide-menu"> Incomes </span></a>
                        </li>

                      <li class="sidebar-item"><a href="Main.php" class="sidebar-link"><span
                                class="hide-menu"> Bank Accounts </span></a></li>


      
                        </ul>
                    </li>

                    <li class="sidebar-item">
    <a class="sidebar-link" href="POS.php" aria-expanded="false">
        <i class="fas fa-cash-register"></i>  <!-- POS icon example -->
        <span class="hide-menu">POS</span>
    </a>
</li>




                     <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                         aria-expanded="false"><i data-feather="users" class="feather-icon"></i><span
                          class="hide-menu">Employees</span></a>


                          <ul aria-expanded="false" class="collapse  first-level base-level-line">



                              <li class="sidebar-item"><a href="AddEmployee.php" class="sidebar-link"><span
                                         class="hide-menu">  Add New Employess
                                     </span></a>
                                  </li>

                                  <?php if ($user_role == 'Manager'): ?>
                                  

                            <li class="sidebar-item"><a href="ManageEmployee.php" class="sidebar-link"><span
                               class="hide-menu"> Mange Employees </span></a>
                            </li>

                     <li class="sidebar-item"><a href="EmployeeRole.php" class="sidebar-link"><span
                           class="hide-menu"> Manage Roles</span></a>
                          </li>    
                          <?php endif; ?>                     
                         </ul>
                                                                                                                                   
                     </li>

                    


                     <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                      aria-expanded="false"><i data-feather="users" class="feather-icon"></i><span
                      class="hide-menu">Rout Maps</span></a>
                     
  



                     <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                             aria-expanded="false"><i data-feather="file" class="feather-icon"></i><span
                                 class="hide-menu">Reports </span></a> 
                         <ul aria-expanded="false" class="collapse first-level base-level-line">
                             <li class="sidebar-item"><a href="Main.php" class="sidebar-link"><span
                                         class="hide-menu"> Sale Report </span></a></li>

                             <li class="sidebar-item"><a href="Main.php" class="sidebar-link"><span
                                         class="hide-menu"> Purchase Reports </span></a></li>

                              <li class="sidebar-item"><a href="Main.php" class="sidebar-link"><span
                                          class="hide-menu"> Accounting Reports </span></a></li>

                              <li class="sidebar-item"><a href="Main.php" class="sidebar-link"><span
                                          class="hide-menu"> Client Reports </span></a></li>

                         </ul>
                     </li>



                
                               <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                     aria-expanded="false"><i data-feather="settings" class="feather-icon"></i><span
                                          class="hide-menu">Settings  </span></a>

                                          

                         <ul aria-expanded="false" class="collapse first-level base-level-line">
                               <li class="sidebar-item"><a href="Asetting.php" class="sidebar-link"><span
                                         class="hide-menu"> Account Setting </span></a></li>

                             <li class="sidebar-item"><a href="Main.php" class="sidebar-link"><span
                                         class="hide-menu"> Payment Setting </span></a></li>

             
                   


                 </ul>
             </nav>
             <!-- End Sidebar navigation -->
         </div>
         <!-- End Sidebar scroll-->
     </aside>
     <!-- ============================================================== -->
     <!-- End Left Sidebar - style you can find in sidebar.scss  -->
     <!-- ============================================================== -->
     <!-- ============================================================== -->
     <!-- Page wrapper  -->
     <!-- ============================================================== -->
     <div class="page-wrapper">
        </div>

