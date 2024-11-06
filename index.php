<?php

define('PROJECT_ROOT', __DIR__); // Assumes index.php is in the root folder
session_start();
//include('views/user/login.php');
include_once('app/Controller/AdminController.php');
include_once('app/Controller/UserController.php');

// Check if the admin is logged in
if (isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id'])) {
    header('Location: /admin/dashboard');
    exit();
}

// Check if a user is logged in
elseif (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    header('Location: /user/dashboard');
    exit();
}

// If not logged in, display the default content
else {
    header('Location: /user/login');
    exit();
}


?>