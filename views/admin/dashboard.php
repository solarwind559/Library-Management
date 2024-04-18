<?php

session_start();

// Check if the user is authenticated
if (!isset($_SESSION['admin_id'])) {
    // Redirect to the login page (adjust the URL as needed)
    header('Location: login');
    exit();
}
  
$page_title = "Librarian Dashboard";
include_once('header.php');
include_once('../../app/Controller/UserController.php');

// get database connection
$database = new Database();
$db = $database->getConnection();
  
// pass connection to objects
$book = new Book($db);
$category = new Category($db);
$user = new UserController($db);

// fetch the number of records in database
$bookCount = $book->countAll();
$userCount = $user->countAll();

?>

<h2 class="text-center mt-4">Current library statistics</h2>

<div class="d-flex justify-content-around py-5">

    <div class="icon text-center"><a href="book_list">
        <?php include_once('../../public/assets/img/book_icon.svg'); ?>    
        <p class="span-number mt-3"> [ <?php echo $bookCount; ?> ]</p>
        <p>books</p></a>
    </div>

    <div class="icon text-center"><a href="user_list">
    <?php include_once('../../public/assets/img/users_icon.svg'); ?>    
        <p class="span-number mt-3"> [ <?php echo $userCount; ?> ] </p>
        <p>users</p></a>
    </div>

    <div class="icon text-center"><a href="borrowed_books">
    <?php include_once('../../public/assets/img/exclamation_icon.svg'); ?>    
        <p class="span-number mt-3"> [ 0 ] </p>
        <p>overdue books</p></a>
    </div>

</div>

<?php include_once('../partials/footer.php');?>

