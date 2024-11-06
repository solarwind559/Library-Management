<?php
include_once(__DIR__ . '/../../config/db.php');
include_once(__DIR__ . '/../../app/Controller/BookController.php');
use App\Controllers\BookController;

$database = new Database();
$db = $database->getConnection();

if (isset($_POST['book_id'])) {
    $book_id = $_POST['book_id'];
    $_POST['return-form'] === 'return-form';
    // Create an instance of BookController
    $bookController = new BookController($db);

    // Start output buffering
    ob_start();

    // Call the returnBook function
    if ($bookController->returnBook($book_id)) {
        echo "<div class='alert alert-success' role='alert'>
        Book was returned successfully.
    </div>";
        // Redirect to a success page or any other desired URL
        $redirectUrl = $_SERVER['HTTP_REFERER'] . '?success=1'; // Example: Redirect back to the referring page
        header("Location: $redirectUrl");
        exit;
    } else {
        echo "Error while returning the book.";
    }

    // End output buffering and flush the output
    ob_end_flush();
}
?>
