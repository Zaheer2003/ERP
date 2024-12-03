


<?php
session_start();
include('LRHeader.php'); 
include('db_connect.php'); // Include database connection settings

// Initialize variables for error messages
$nameError = $emailError = $passwordError = $passwordConfirmError = $registrationMessage = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $passwordConfirm = $_POST['passwordConfirm'];

    // Validation
    if (empty($name)) {
        $nameError = "Name is required.";
    }
    if (empty($email)) {
        $emailError = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "Invalid email format.";
    }

    // Password validation
    if (empty($password)) {
        $passwordError = "Password is required.";
    } elseif (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/", $password)) {
        $passwordError = "Password must be at least 6 characters and contain letters and numbers.";
    }

    // Password confirmation
    if ($password !== $passwordConfirm) {
        $passwordConfirmError = "Passwords do not match.";
    }

    // If no errors, proceed with registration
    if (empty($nameError) && empty($emailError) && empty($passwordError) && empty($passwordConfirmError)) {
        // Check if the email already exists in the database
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            $emailError = "Email is already registered.";
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Generate a unique verification code
            $verificationCode = bin2hex(random_bytes(16)); // Generate a random 32-character code

            // Insert the new user into the database
            $insertQuery = "INSERT INTO users (name, email, password, verification_code) VALUES (?, ?, ?, ?)";
            $insertStmt = $pdo->prepare($insertQuery);
            $insertStmt->execute([$name, $email, $hashedPassword, $verificationCode]);

            // Send confirmation email
            $to = $email;
            $subject = "Please confirm your registration";
            $message = "Dear $name,\n\nPlease confirm your registration by clicking the link below:\n";
            $message .= "http://yourwebsite.com/confirm.php?code=$verificationCode\n\nThank you!";
            $headers = 'From: no-reply@yourwebsite.com' . "\r\n" .
                'Reply-To: no-reply@yourwebsite.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            // Send the email
            if (mail($to, $subject, $message, $headers)) {
                $registrationMessage = "Registration successful! Please check your email to confirm your account.";
            } else {
                $registrationMessage = "Error sending confirmation email.";
            }
        }
    }
}
?>


    <div class="main-wrapper">
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative"
            style="background: url('../ERPAssest/admintemplate/assets/images/big/auth-bg.jpg') no-repeat center center;">
            <div class="auth-box row text-center">
                <div class="col-lg-7 col-md-5 modal-bg-img" style="background-image: url('../ERPAssest/admintemplate/assets/images/big/6.jpg');">
                </div>
                <div class="col-lg-5 col-md-7 bg-white">
                    <div class="p-3">
                        <img src="../ERPAssest/admintemplate/assets/images/big/i" alt="wrapkit" />
                        <h2 class="mt-3 text-center">Sign Up for Free</h2>
                        <form method="POST" action="Register.php">
                            <div class="mt-4">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="name" placeholder="Your name" value="<?= isset($_POST['name']) ? $_POST['name'] : '' ?>">
                                            <span class="text-danger"><?= $nameError ?></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <input type="email" class="form-control" name="email" placeholder="Email address" value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>">
                                            <span class="text-danger"><?= $emailError ?></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <input type="password" class="form-control" name="password" placeholder="Password">
                                            <span class="text-danger"><?= $passwordError ?></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <input type="password" class="form-control" name="passwordConfirm" placeholder="Confirm Password">
                                            <span class="text-danger"><?= $passwordConfirmError ?></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 text-center">
                                        <button type="submit" class="btn btn-block btn-dark">Sign Up</button>
                                    </div>
                                    <div class="col-lg-12 text-center mt-3">
                                        <span class="text-success"><?= $registrationMessage ?></span>
                                    </div>
                                    <div class="col-lg-12 text-center mt-5">
                                        Already have an account? <a href="Login.php" class="text-danger">Sign In</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('LRFooter.php'); ?> 