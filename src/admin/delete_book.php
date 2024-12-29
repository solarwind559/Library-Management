<?php
// Is the session already active?
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once(__DIR__ . '/../../config/db.php');
include_once(__DIR__ . '/../../app/Model/Book.php');

$database = new Database();
$db = $database->getConnection();

$book = new Book($db);

if (isset($_GET['id'])) {
    $book->id = $_GET['id'];

    if ($book->delete()) {
        $_SESSION['message'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
        The book was deleted successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    } else {
        $_SESSION['message'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        The book could not be deleted.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }

    // Redirect to the referring page
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}