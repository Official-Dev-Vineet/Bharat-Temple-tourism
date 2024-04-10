<?php
// Initialize the session
session_start();

unset($_SESSION['Admin_id']);
unset($_SESSION['AdminName']);
unset($_SESSION['AdminEmail']);


// destroy the session
session_destroy();
header("Location: login.php");

?>