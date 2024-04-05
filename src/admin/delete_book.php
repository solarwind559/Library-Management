<?php

include_once('../../config/db.php');
include_once('../../app/Model/Book.php');

$database = new Database();
$db = $database->getConnection();

$book = new Book($db);

if (isset($_GET['id'])) {
    $book->id = $_GET['id'];
    
    if ($book->delete()) {
        echo "Object was deleted.";
        echo "<br><a href='dashboard.php'>Go back</a>";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;

    } else {
        echo "Unable to delete object.";
        echo "<br><a href='dashboard.php'>Go back</a>";
    }
} 
// else {
//     echo "Invalid book ID.";
// }
?>
