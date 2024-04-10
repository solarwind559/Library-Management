<?php

session_start();

// Check if the user is authenticated
if (!isset($_SESSION['admin_id'])) {
    // Redirect to the login page (adjust the URL as needed)
    header('Location: login');
    exit();
}

// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;
  
// set number of records per page
$records_per_page = 7;
  
// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;
  
$page_title = "Browse users";
include_once('header.php');

include_once('../../app/Controller/UserController.php');
include_once('../../app/Controller/BookController.php');


// get database connection
$database = new Database();
$db = $database->getConnection();
  
// pass connection to objects
$book = new Book($db);
$user = new UserController($db);

// $category = new UserController($db);

// query users
$stmt = $user->viewAll($from_record_num, $records_per_page);
$num = $stmt->rowCount();

// Assume you have classes for User, Book, and Database connection

// When the user clicks a button (e.g., "Borrow Book")
if (isset($_POST['borrow'])) {
    $user_id = $_POST['user_id']; // Get user ID from form
    $book_id = $_POST['book_id']; // Get book ID from form

    // Insert into borrowed_books table
    // (Assuming you have a method to insert records)
    $borrowed_book = new BookController($db);
    $borrowed_book->borrowBook($user_id, $book_id);

    // Optionally, update book status (e.g., set it as borrowed)


}
?>

<!-- Example HTML form -->
<form method="post">
    User ID: <input type="text" name="user_id">
    Book ID: <input type="text" name="book_id">
    <button type="submit" name="borrow">Borrow Book</button>
</form>



<?php
//$page_url = "dashboard.php?";
$page_url = "?";
$total_rows = $user->countAll();
include_once('../../pagination.php');
//include the script
include_once('../partials/footer.php');
?>