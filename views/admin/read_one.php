<?php
$page_title = "View Book Info";
include_once('header.php');

$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

$database = new Database();
$db = $database->getConnection();
  
$book = new Book($db);
$category = new Category($db);
  
// set ID property of book to be edited
$book->id = $id;
  
// read the details of book to be edited
$book->readOne();
$status = $book->status;
$status_message = ($status == 1) ? "<b style='color:#dc3545;'>Borrowed</b>" : "<b style='color:#198754;'>Available</b>";

?>

<?php
    // Check if the HTTP_REFERER is set
    if (isset($_SERVER['HTTP_REFERER'])) {
        $referrer = $_SERVER['HTTP_REFERER'];
        echo '<a href="' . $referrer . '"><button class="btn btn-primary">Go Back</button></a><br><br>';
    } else {
        echo 'No referrer found.';
    }
?>

<?php

// HTML table for displaying a book details
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
       "<td>
    </tr>

</table>";
?>
