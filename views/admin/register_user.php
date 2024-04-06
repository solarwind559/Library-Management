<?php
$page_title = "Register A New Library User";
include_once('header.php');
include_once('../../app/Model/UserRegister.php');
include_once('../../config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name']; // Use null coalescing operator to provide a default value
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $db = new Database();
    $conn = $db->getConnection();

    // Create a UserRegister object with the database connection
    $newUser = new UserRegister($conn);

    // Set user properties
    $newUser->name = $name;
    $newUser->surname = $surname;
    $newUser->email = $email;
    $newUser->setPassword($password); // Set the hashed password


        // Validate input
        $validationError = $newUser->validateInput();
        if ($validationError) {
            echo $validationError;
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
?>

<div class="container">
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
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
    </div>
    <div class="mb-3" id="generate-random">
        <label for="password" class="form-label">Password</label>
        <input type="text" class="form-control" id="password" name="password">
        <button class="btn btn-secondary mt-3" id="generate" type="button">Generate Student Password</button>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button> <br><br>
    </form>    
</div>


<!-- <div class="mb-3" id="generate-random">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password">
    <button id="generate" type="button">Generate Student Password</button>
</div> -->
<script>
document.getElementById('generate').addEventListener('click', function () {
    const passwordLength = 12; // Set your desired password length
    const includeNumbers = true; // Include numbers (customize as needed)
    const includeSymbols = true; // Include symbols (customize as needed)

    let charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; // Alphabets
    if (includeNumbers) {
        charset += '0123456789'; // Add numbers
    }
    if (includeSymbols) {
        charset += '!@#$%^&*()_+[]{}|;:,.<>?'; // Add symbols
    }

    let generatedPassword = '';
    for (let i = 0; i < passwordLength; i++) {
        const randomIndex = Math.floor(Math.random() * charset.length);
        generatedPassword += charset[randomIndex];
    }

    document.getElementById('password').value = generatedPassword;
});
</script>

<?php
include_once('../partials/footer.php')
?>