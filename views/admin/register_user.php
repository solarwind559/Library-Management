<?php
$page_title = "Register a new Library User";
include_once('header.php');
include_once(__DIR__ . '/../../app/Controller/UserController.php');
include_once(__DIR__ . '/../../config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $database = new Database();
    $db = $database->getConnection();

    $newUser = new UserController($db);

    $newUser->name = $name;
    $newUser->surname = $surname;
    $newUser->email = $email;
    $newUser->setPassword($password); // Set the hashed password

     // Validate input
    $validationError = $newUser->validateInput();
    if ($validationError) {
        echo $validationError;
    } else {
        // Verify that the entered password matches the confirmed password
        $enteredPassword = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
        if (!$newUser->verifyPassword($enteredPassword, $confirmPassword)) {
            echo '<div class="alert alert-danger" role="alert">
            Passwords do not match.
            </div>';
        } else {
            // Save user data to the database
            if ($newUser->saveToDatabase()) {
                echo '<div class="alert alert-success" role="alert">
                User registered successfully!
                </div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">
                Error: Unable to save user data.
                </div>';
            }
        }
    }
}
?>

<form class="p-5" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
    <div class="mb-3">
        <label for="formGroupExampleInput" class="form-label">Name</label>
        <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Name" name="name">
        </div>
        <div class="mb-3">
        <label for="formGroupExampleInput2" class="form-label">Surname</label>
        <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Surname" name="surname">
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="email@email.com" aria-describedby="emailHelp" name="email">
    </div>
    <div class="mb-3" id="generate-random">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="********">
        <button class="btn btn-secondary mt-3" id="generate" type="button">Generate Student Password</button>
        <!-- toggle between password visibility -->
        <div class="my-3">
            <input type="checkbox" class="toggle" onclick="showPassword()"> Show Password 
        </div>             
        <label for="password" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="********">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button> <br><br>
</form>    

<script>
document.getElementById('generate').addEventListener('click', function () {
    const passwordLength = 10;
    const includeNumbers = true;
    const includeSymbols = true;

    let charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    if (includeNumbers) {
        charset += '0123456789';
    }
    if (includeSymbols) {
        charset += '!@#$%&*+<>?';
    }

    let generatedPassword = 'id_' + '';
    for (let i = 0; i < passwordLength; i++) {
        const randomIndex = Math.floor(Math.random() * charset.length);
        generatedPassword += charset[randomIndex];
    }

    document.getElementById('password').value = generatedPassword;
});

function showPassword() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>

<?php include_once('../partials/footer.php')?>