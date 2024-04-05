<?php
// logout.php

// Start or resume the session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page (adjust the URL as needed)
// header('Location: /library-management/admin/admin_login.php');
header('Location: ../../views/admin/login');

exit();
?>
