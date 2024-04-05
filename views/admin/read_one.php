<?php
// get ID of the book to be edited
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
  
// include database and object files
include_once('../../config/db.php');
include_once('../../app/Model/Book.php');
include_once('../../app/Model/Category.php');

// get database connection
$database = new Database();
$db = $database->getConnection();
  
// pass connection to objects
$book = new Book($db);
$category = new Category($db);
  
// set ID property of book to be edited
$book->id = $id;
  
// read the details of book to be edited
$book->readOne(); 

$page_title = "Add Books";
include_once('header.php');
  
?>

<?php
    // Check if the HTTP_REFERER is set
    if (isset($_SERVER['HTTP_REFERER'])) {
        $referrer = $_SERVER['HTTP_REFERER'];
        echo '<a href="' . $referrer . '"><button>Go Back</button></a><br><br>';
    } else {
        echo 'No referrer found.';
    }
?>

<?php
// HTML table for displaying a book details
echo "<table class='table table-hover table-responsive table-bordered'>
  
    <tr>
        <td>Title</td>
        <td>{$book->title}</td>
    </tr>
  
    <tr>
        <td>Author</td>
        <td>{$book->author}</td>
    </tr>
  
  
    <tr>
        <td>Category</td>
        <td>";
            // display category name
            $category->id=$book->category_id;
            $category->readName();
            echo $category->name;
        echo "</td>
    </tr>
  
</table>";
?>
