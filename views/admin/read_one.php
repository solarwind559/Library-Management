<?php
$page_title = "View Book Info";

include_once('header.php');
include_once(__DIR__ . '/../../app/Controller/BookController.php');
use App\Controllers\BookController;

$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

// initialize database and controllers
$database = new Database();
$db = $database->getConnection();
$book = new Book($db);
$category = new Category($db);
$bookController = new BookController($db);

// set book id's and read their details
$book->id = $id;
$book->readOne();

// check book status
$status = $book->status;
$status_message = ($status == 1) ? "<b style='color:#dc3545;'>Borrowed</b>" : "<b style='color:#198754;'>Available</b>";

// get book borrower details if book is borrowed
$borrowerDetails = $status == 1 ? $bookController->getBorrowerDetails($book->id) : null;

// display go back button
if (isset($_SERVER['HTTP_REFERER'])) {
    $referrer = $_SERVER['HTTP_REFERER'];
    echo '<a href="' . $referrer . '"><button class="btn btn-primary">Go Back</button></a><br><br>';
} else {
    echo 'No referrer found.';
}

// display the table with data
echo "<table class='table table-hover table-bordered'>
  
    <tr>
        <th class='col-4'>Title</th>
        <td class='col-8'>{$book->title}</td>
    </tr>
  
    <tr>
        <th class='col-4'>Author</th>
        <td class='col-8'>{$book->author}</td>
    </tr>
  
    <tr>
        <th class='col-4'>Category</th>
        <td class='col-8'>";
            $category->id=$book->category_id;
            $category->readName();
            echo $category->name;
        echo "</td>
    </tr>

    <tr>
        <th class='col-4'>Book Status</th>
        <td class='col-8'>";
            echo $status_message;
            if ($borrowerDetails) {
                $userId = $borrowerDetails['user_id'];
                echo ' (by 
                <a href="view_one_user.php?id=' . $userId . '">
                    <strong>' . $borrowerDetails["full_name"] . '</strong>)
                </a>';
            }
        "<td>
    </tr>

</table>";
?>

