<?php
include_once('../../config/db.php');
include_once('../../app/Controller/BookController.php');

$database = new Database();
$db = $database->getConnection();

if (isset($_POST['book_id'])) {
    $book_id = $_POST['book_id'];
    $_POST['return-form'] === 'return-form';
    // Create an instance of BookController
    $bookController = new BookController($db);

    // Call the returnBook function
    if ($bookController->returnBook($book_id)) {
        echo "<div class='alert alert-success' role='alert'>
        Book was returned successfully.
    </div>";
        // header("Location: {$_SERVER['HTTP_REFERER']}");
        header("Location: {$_SERVER['HTTP_REFERER']}?success=1");
        exit;
    } else {
        echo "Error while returning the book.";
    }
}
?>
