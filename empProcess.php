<?php

// Include Composer autoloader (if using Composer)
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include 'db_connect.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get employee form data
    $firstName = $_POST['firstName'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $status = $_POST['status'];
    $role = $_POST['role'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $country = $_POST['country'];
    $mobileNumber = $_POST['mobileNumber'];
    $addressLine1 = $_POST['addressLine1'];
    $addressLine2 = $_POST['addressLine2'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $postalCode = $_POST['postalCode'];

    // Move uploaded image to the desired folder (if any)
    $targetDirectory = "uploads/"; // Folder for uploaded images
    $targetFile = $targetDirectory . basename($_FILES['employeePicture']['name']);
    move_uploaded_file($_FILES['employeePicture']['tmp_name'], $targetFile);

    // Insert employee data into the employees table
    $sqlEmployee = "INSERT INTO employee (
        firstName, surname, emailAddress, status, role, dob, gender, country, mobileNumber, 
        addressLine1, addressLine2, city, state, postalCode, employeePicture
    ) VALUES (
        :firstName, :surname, :email, :status, :role, :dob, :gender, :country, :mobileNumber, 
        :addressLine1, :addressLine2, :city, :state, :postalCode, :employeePicture
    )";

    $stmtEmployee = $pdo->prepare($sqlEmployee);
    $stmtEmployee->bindParam(':firstName', $firstName);
    $stmtEmployee->bindParam(':surname', $surname);
    $stmtEmployee->bindParam(':email', $email);
    $stmtEmployee->bindParam(':status', $status);
    $stmtEmployee->bindParam(':role', $role);
    $stmtEmployee->bindParam(':dob', $dob);
    $stmtEmployee->bindParam(':gender', $gender);
    $stmtEmployee->bindParam(':country', $country);
    $stmtEmployee->bindParam(':mobileNumber', $mobileNumber);
    $stmtEmployee->bindParam(':addressLine1', $addressLine1);
    $stmtEmployee->bindParam(':addressLine2', $addressLine2);
    $stmtEmployee->bindParam(':city', $city);
    $stmtEmployee->bindParam(':state', $state);
    $stmtEmployee->bindParam(':postalCode', $postalCode);
    $stmtEmployee->bindParam(':employeePicture', $targetFile); // Assuming the picture is optional

    if ($stmtEmployee->execute()) {
        // Get the last inserted employee ID
        $employee_id = $pdo->lastInsertId();

        // Generate a random password
        $generatedPassword = bin2hex(random_bytes(8)); // 16-character password

        // Hash the password
        $hashedPassword = password_hash($generatedPassword, PASSWORD_DEFAULT);

        // Create the username by concatenating first name and surname
        $username = strtolower($firstName . $surname); // Convert to lowercase and concatenate
// Assuming you already have employee picture in the $targetFile variable (from the Employee table)
$userPicture = $targetFile; // Use the same value for the User table

// SQL query to insert user data, including the userPicture
$sqlUser = "INSERT INTO users (username, employee_id, email, password, status, role, userPicture) 
            VALUES (:username, :employee_id, :email, :password, :status, :role, :userPicture)";

$stmtUser = $pdo->prepare($sqlUser);
$stmtUser->bindParam(':username', $username); // Bind the username
$stmtUser->bindParam(':employee_id', $employee_id);
$stmtUser->bindParam(':email', $email);
$stmtUser->bindParam(':password', $hashedPassword);
$stmtUser->bindParam(':status', $status);
$stmtUser->bindParam(':role', $role);
$stmtUser->bindParam(':userPicture', $userPicture); // Bind the userPicture


        if ($stmtUser->execute()) {
            // Send registration email with the password

            // Create PHPMailer instance
            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'mhdzaheer572@gmail.com'; // Use your email
                $mail->Password = 'odfvluezxdrljebv'; // Use your email app password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Recipients
                $mail->setFrom('mhdzaheer572@gmail.com', 'CATCHBOOT');
                $mail->addAddress($email); // Add employee email

                // Email content
                $mail->isHTML(true);
                $mail->Subject = 'Employee Registration - Your Login Credentials';
                $mail->Body = "Dear $firstName $surname,<br><br>
                               You have been successfully registered.<br><br>
                               <strong>Your username:</strong> $username<br><br>
                               <strong>Your password:</strong> $generatedPassword<br><br>
                               Please keep your login credentials secure.";

                // Send the email
                $mail->send();
                echo 'The employee has been added and the email has been sent with login credentials.';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo 'Failed to insert user login details.';
        }
    } else {
        echo 'Failed to add employee details.';
    }
}

// Insert activity into 'activities' table
$activityQuery = "INSERT INTO activities (icon, btn_class, title, description, time_elapsed) 
                  VALUES (:icon, :btn_class, :title, :description, :time_elapsed)";
$activityStmt = $conn->prepare($activityQuery);

$activityStmt->execute([
    ':icon' => 'user-plus',  // Feather icon name for adding user
    ':btn_class' => 'btn-success',  // Bootstrap class for styling
    ':title' => 'New Employee Added',
    ':description' => "$name joined as $position.",
    ':time_elapsed' => 'Just Now'
]);

?>
