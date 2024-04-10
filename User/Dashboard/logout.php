<?php
// Initialize the session
session_start();

unset($_SESSION['id']);
unset($_SESSION['name']);
unset($_SESSION['email']);
unset($_SESSION['phone']);
unset($_SESSION['city']);
unset($_SESSION['state']);
unset($_SESSION['country']);
unset($_SESSION['pincode']);
unset($_SESSION['user_id']);

// clear cookies 

setcookie('user_id', '', time() - (86400 * 30), "/");

// Redirect to the login page

// destroy the session
session_destroy();
header("Location: ../index.php");

?>