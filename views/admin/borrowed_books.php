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
  
$records_per_page = 100;
  
$from_record_num = ($records_per_page * $page) - $records_per_page;
  
$page_title = "View borrowed books";

include_once('header.php');
include_once('../../app/Controller/BookController.php');
include_once('../../app/Controller/UserController.php');
// include_once '../../src/admin/return_book.php';

$database = new Database();
$db = $database->getConnection();

$user = new UserController($db);
$bookView = new BookController($db);
$bookView->showBorrowedBooks();
$book = new Book($db);

$stmt = $bookView->showBorrowedBooks();
$stmt2 = $user->viewAll($from_record_num, $records_per_page);
$stmt3 = $book->readAll($from_record_num, $records_per_page);

// if (isset($_POST['user_id']) && isset($_POST['book_id'])) {
//     $user_id = $_POST['user_id'];
//     $book_id = $_POST['book_id'];
//     $bookView->borrowBook($user_id, $book_id);
//     } 
    if (isset($_GET['success']) && $_GET['success'] == 1) {
        echo "<div class='alert alert-success' role='alert'>
            Book was returned successfully.
        </div>";
    }

?>


<?php
if ($stmt->rowCount() > 0) {

    echo "<table class='table table-striped'>";
    echo "<tr scope='row' class='table-dark'><th>Borrowed Book:</th><th>Borrowed by:</th><th>Borrow Date:</th><th>Return Date:</th><th></th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row); // Extract the values from the fetched row

        echo "<tr scope='row'>";
        echo "<td>{$title}</td>";
        echo "<td>{$full_name}</td>";
        echo "<td>{$borrow_date}</td>";
        echo "<td>{$return_date}</td>";
        echo "<td>
            <form action='../../src/admin/return_book.php' method='post' id='return-form'>
                <input type='hidden' name='return-form' value='return-form'>
                <input type='hidden' name='book_id' value='{$book_id}'>
                <button class='btn btn-outline-success' type='submit' value='confirmBookReturn();'>Book Returned</button>
            </form>
        </td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No borrowed books found.";
}
?>

<?php

$page_url = "?";
// $total_rows = $book->countAll();
// include_once('../../pagination.php');
//include the script
include_once('../partials/footer.php');
?>

