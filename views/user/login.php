<?php
// Start or resume the session
session_start();

$page_title = "User Login";

include_once('header.php');

include_once('../../app/Controller/UserController.php');

// Check if the form has been submitted

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    $db = $database->getConnection();
    $user = new UserController($db);

    $email = $_POST['email'];
    $password = $_POST['password'];
    // $name = $_SESSION['name'];
    // $surname = $_SESSION['surname'];

    if ($user->validateEmail($email) && $user->validatePassword($password)) {
        $user_id = $user->validateLogin($email, $password);
        $user->viewOne();
        if ($user_id) {
            $_SESSION['user_id'] = $user_id;
            // $_SESSION['name'] = $user->name;
            // $_SESSION['surname'] = $user->surname;

            header('Location: dashboard'); // Redirect to the protected page
            exit();
        } else {
            echo "<div class='alert alert-danger' role='alert'>Invalid email or password.</div>";
        }

    } else {
        echo "<div class='alert alert-danger' role='alert'>Invalid email or password format.</div>";
    }
}


// Example logout process (logout.php)
if (isset($_GET['logout'])) {
   UserController::logout(); // Call the logout method
}

?>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="form-group">
        <!-- <p>Please, sign in</p> -->
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