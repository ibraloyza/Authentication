<?php
session_start();

$session_timeout = 60; 


if (isset($_SESSION['last_active'])) {
    $inactive = time() - $_SESSION['last_active']; 
    if ($inactive > $session_timeout) {
        
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }
}


$_SESSION['last_active'] = time();


if(!isset($_SESSION['authenticated'])) {
    $_SESSION['status'] = "Please Login to Access User Dashboard!"; 

    header("Location: login.php"); 
    Exit(0); 
}
?>
