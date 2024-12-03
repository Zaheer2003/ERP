
<?php
include('LRHeader.php');
session_start(); // Start the session to handle user authentication
 

// Initialize variables for error messages
$emailError = $passwordError = $loginError = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Basic validation (you can add more checks)
    if (empty($email)) {
        $emailError = "Email is required.";
    }
    if (empty($password)) {
        $passwordError = "Password is required.";
    }

    
}
?>



<body>
    <div class="main-wrapper">
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative"
            style="background:url('../ERPAssest/admintemplate/assets/images/big/auth-bg.jpg') no-repeat center center;">
            <div class="auth-box row">
                <div class="col-lg-7 col-md-5 modal-bg-img" style="background-image: url('../ERPAssest/assets/images/big/6.jpg');">
                </div>
                <div class="col-lg-5 col-md-7 bg-white">
                    <div class="p-3">
                        <div class="text-center">
                            <img src="../ERPAssest/admintemplate/assets/images/big/i" alt="wrapkit">
                        </div>
                        <h2 class="mt-3 text-center">Sign In</h2>
                        <p class="text-center">Enter your email address and password to access your account.</p>
                        <form method="POST" action="Login.php">
                            <div class="mt-4">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="email" class="text-dark">Email Address</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>">
                                            <span class="text-danger"><?= $emailError ?></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="password" class="text-dark">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                                            <span class="text-danger"><?= $passwordError ?></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 text-center">
                                        <button type="submit" class="btn btn-block btn-dark">Sign In</button>
                                    </div>
                                    <div class="col-lg-12 text-center mt-3">
                                        <span class="text-danger"><?= $loginError ?></span>
                                    </div>
                                    <div class="col-lg-12 text-center mt-5">
                                        Don't have an account? <a href="Register.php" class="text-danger">Sign Up</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('LRFooter.php'); ?> <!-- Include footer -->