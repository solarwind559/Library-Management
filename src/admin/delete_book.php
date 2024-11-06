<?php

include_once(__DIR__ . '/../../config/db.php');
include_once(__DIR__ . '/../../app/Model/Book.php');

$database = new Database();
$db = $database->getConnection();

$book = new Book($db);

if (isset($_GET['id'])) {
    $book->id = $_GET['id'];
    
    // Start output buffering
    ob_start();

    if ($book->delete()) {
        echo "Object was deleted.";
        echo "<br><a href='dashboard'>Go back</a>";
        // Redirect to the referring page
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
    } else {
        echo "Unable to delete object.";
        echo "<br><a href='dashboard'>Go back</a>";
    }

    // End output buffering and flush the output
    ob_end_flush();
} 
// else {
//     echo "Invalid book ID.";
// }
?>
