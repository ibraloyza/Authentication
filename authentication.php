<?php
session_start();

$session_timeout = 300; // Set to 5 minutes for better usability

// Check session timeout
if (isset($_SESSION['last_active'])) {
    $inactive = time() - $_SESSION['last_active'];
    if ($inactive > $session_timeout) {
        // Session has expired
        session_unset();
        session_destroy();
        header("Location: ./pages/login.php"); // Ensure this path is correct
        exit(); // Use lowercase 'exit'
    }
}

// Update session activity timestamp
$_SESSION['last_active'] = time();

// Check if the user is authenticated
if (!isset($_SESSION['authenticated'])) {
    $_SESSION['status'] = "Please Login to Access User Dashboard!";
    header("Location: ./pages/login.php");
    exit(); // Use lowercase 'exit'
}
?>
