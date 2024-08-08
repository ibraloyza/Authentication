<?php
session_start(); 

include 'dbconn.php'; 

use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception; 

// Load Composer's autoloader
require 'vendor/autoload.php';

// Function to send a verification email
function sendemail_verify($name, $email, $verify_token) {
    $mail = new PHPMailer(true); 

    $mail->isSMTP(); 
    $mail->Host = 'smtp.gmail.com'; 
    $mail->SMTPAuth = true; 
    $mail->Username = 'ibraahim3523@gmail.com'; 
    $mail->Password = 'fxkksgazxmaujeug'; 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
    $mail->Port = 587; 

    $mail->setFrom('ibraahim3523@gmail.com', $name); 
    $mail->addAddress($email); 

    $mail->isHTML(true); 
    $mail->Subject = 'Email verification from WEB OF IT'; 
    $mail->Body    = "
    <h2>You have Registered with WEB OF IT</h2>
    <h5>Verify your email address to login with the below given link</h5>
    <br /><br />
    <a href='http://localhost/Authentication/verify-email.php?token=$verify_token'>Click Me</a>
    "; 

    //send the email
    $mail->send(); 
    
} 

// Check if the register button is clicked
if(isset($_POST['register_btn'])) { 

    // Function to validate and sanitize user input
    function validate($date) {
        $date = trim($date); 
        $date = stripslashes($date); 
        $date = htmlspecialchars($date); 
        return $date;
    }

    // Validate and sanitize user input
    $name = validate($_POST['name']);
    $phone_number = validate($_POST['phone']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $confirm_password = validate($_POST['confirm_password']);
    $verify_token = md5(rand()); 

    // Check if any input field is empty and set a session status message
    if(empty($name)) {

        $_SESSION['status'] = "Name is required";
        header("location: register.php");
        exit();

    } else if(empty($phone_number)) {

        $_SESSION['status'] = "Phone Number is required";
        header("location: register.php");
        exit();

    } else if(empty($email)) {

        $_SESSION['status'] = "Email Address is required";
        header("location: register.php");
        exit();

    } else if(empty($password)) {

        $_SESSION['status'] = "Password is required";
        header("location: register.php");
        exit();

    } else if(empty($confirm_password)) {

        $_SESSION['status'] = "Confirm Password is required";
        header("location: register.php");
        exit();

    }
     
    // Check if the email already exists in the database
    $check_email_query = "SELECT email FROM register_php WHERE email = '$email'";
    $result_check_email = mysqli_query($conn, $check_email_query);
    if(mysqli_num_rows($result_check_email) > 0) {

        $_SESSION['status'] = "Email address already Exists";
        header("location: register.php");
        exit();
    }

    // Check if the phone number already exists in the database
    $check_phone_query = "SELECT phone FROM register_php WHERE phone = '$phone_number'";
    $result_phone_email = mysqli_query($conn, $check_phone_query);
    if(mysqli_num_rows($result_phone_email) > 0) {

        $_SESSION['status'] = "Phone Number already Exists";
        header("location: register.php");
        exit();
    } else {

        // Check if the password and confirm password match
        if($password === $confirm_password) {

            // Insert the user data into the database
            $query = "INSERT INTO register_php(name, phone, email, password, confirm_password, verify_token) 
                      VALUES ('$name', '$phone_number', '$email', '$password', '$confirm_password', '$verify_token')";
            $result_query = mysqli_query($conn, $query);
            
            // If the query was successful, send the verification email and set a session status message
            if($result_query) {

                sendemail_verify($name, $email, $verify_token);
                $_SESSION['status'] = "Registration Successful! Please verify your Email Address.";
                header("Location: register.php");
                exit();
            } else {

                $_SESSION['status'] = "Registration Failed";
                header("Location: register.php");
                exit();
            }
        } else {
            
            // Set a session status message if the passwords don't match
            $_SESSION['status'] = "Passwords don't match";
            header("Location: register.php");
            exit();
        }
    }
}
?>
