<?php
session_start();
$email = isset($_GET['email']) ? $_GET['email'] : ''; // Retrieve email from URL parameter

// Clear the session storage item
echo '<script>sessionStorage.removeItem("isLoggedIn");</script>';

session_destroy();
header("Location:../index.php?email=" . $email); // Redirect to index page with email as parameter
exit();
