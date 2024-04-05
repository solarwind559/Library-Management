<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
$page_title = "Admin Login";


include_once('header.php');
// include_once('..\config\db.php');
include_once('../../config/db.php');
// include_once('../../config/root_dir.php');
// $projectRoot = FilesManager::rootDirectory();
// echo "Project root directory: $projectRoot" . '<br>';


include_once('../../app/Model/AdminValidator.php');

// login.php

// Start or resume the session
session_start();

// Include the necessary files (adjust paths as needed)

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    $db = $database->getConnection();
    $auth = new AdminValidator($db);

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate email and password
    if ($auth->validateEmail($email) && $auth->validatePassword($password)) {
        $admin_id = $auth->validateLogin($email, $password);
        if ($admin_id) {
            // User is authenticated, set session variable
            $_SESSION['admin_id'] = $admin_id;
            header('Location: dashboard'); // Redirect to the protected page
            exit();
        } else {
            echo "Invalid login credentials.";
        }
    } else {
        echo "Invalid email or password.";
    }
}

// Example logout process (logout.php)
if (isset($_GET['logout'])) {
   AdminValidator::logout(); // Call the logout method
}


?>
    <!-- <form action="../src/config/validate_admin.php" method="POST"> -->
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="login-box">
            <h1>Login</h1>
 
            <div class="textbox">
                <input type="email" placeholder="email" name="email" value="">
            </div>
 
            <div class="textbox">
                <input type="password" placeholder="Password" name="password" value="">
            </div>
 
            <input class="button" type="submit" name="login" value="Sign In">
        </div>
    </form>
</body>
</html>