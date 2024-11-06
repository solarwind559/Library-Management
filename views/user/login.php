<?php
// Start output buffering
ob_start();

// Start or resume the session
session_start();

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    // User is logged in, redirect to the dashboard
    header('Location: /user/dashboard');
    exit();
}

$page_title = "User Login";

include_once('header.php');
include_once(__DIR__ . '/../../app/Controller/UserController.php');

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    $db = $database->getConnection();
    $user = new UserController($db);

    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($user->validateEmail($email) && $user->validatePassword($password)) {
        $user_id = $user->validateLogin($email, $password);
        $user->viewOne();
        if ($user_id) {
            $_SESSION['user_id'] = $user_id;

            header('Location: /user/dashboard'); // Redirect to the protected page
            exit();
        } else {
            echo "<div class='alert alert-danger' role='alert'>Invalid email or password.</div>";
        }
    } else {
        echo "<div class='alert alert-danger' role='alert'>Invalid email or password format.</div>";
    }
}

if (isset($_GET['logout'])) {
    UserController::logout(); // Call the logout method
}

ob_end_flush(); // End output buffering and flush the output
?>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <div class="form-group">
        <div class="col-12 col-lg-6 mb-3">
            <label for="" class="mb-1">Email Address:</label>
            <input class="form-control" type="email" placeholder="User@example.com" name="email" value="">
        </div>

        <div class="col-12 col-lg-6 mb-3">
            <label for="" class="mb-1">Password:</label>
            <input class="form-control" type="password" placeholder="********" name="password" value="">
        </div>

        <input class="btn btn-primary" type="submit" name="login" value="Sign In">
    </div>
</form>
</body>
</html>
