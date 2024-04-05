<?php
include_once('resources/templates/header.php')
?>


<div class="container">
    <form class="p-5">

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
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" class="form-control" id="exampleInputPassword1" name="password">
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Remember me</label>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button> <br><br>
    <p>No account?</p>
    <a href="/register">Register</a>
    </form>    
</div>



<?php
include('src/Model/User.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Create a User object (assuming you've included the User class)
    $newUser = new User($name, $surname, $email, $password);

    // Save user data to the database (implement this logic)
    $newUser->saveToDatabase();

    echo 'User registered successfully!';
}
?>

<?php
include_once('resources/templates/footer.php')
?>