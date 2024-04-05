<?php



echo "student!";

session_start();

// Check if the user is authenticated
if (!isset($_SESSION['admin_id'])) {
    // Redirect to the login page (adjust the URL as needed)
    header('Location: admin_login.php');
    exit();
}


// core.php holds pagination variables
// include_once 'config/core.php';

// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;
  
// set number of records per page
$records_per_page = 7;
  
// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;
  
// retrieve records here

$page_title = "Browse Books";
// count all books in the database to calculate total pages
  
include_once('../resources/templates/admin/header.php');

include_once '../src/config/db.php';
include_once '../src/Model/Book.php';
include_once '../src/Model/Category.php';
include_once 'delete_book.php';


// get database connection
$database = new Database();
$db = $database->getConnection();
  
// pass connection to objects
$book = new Book($db);
$category = new Category($db);


// query books
$stmt = $book->readAll($from_record_num, $records_per_page);
$num = $stmt->rowCount();


// echo "<div class='right-button-margin'>
//     <a href='create_book.php' class='btn btn-default pull-right'>Create book</a>
// </div>";






// display the books if there are any
if($num>0){
  
    echo "<table class='table table-hover table-responsive table-bordered'>";
        echo "<tr>";
            echo "<th>Title</th>";
            echo "<th>Author</th>";
            echo "<th>Category</th>";
            // echo "<th>Delete</th>";
//             echo "<th><button type='submit' class='btn btn-danger' onclick='return confirmDelete();'>
//     Delete Selected
// </button></th>";

            echo "<th>Actions</th>";
            
        echo "</tr>";
  
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  
            extract($row);
  
            echo "<tr>";
                echo "<td><a href='read_one.php?id={$id}'>{$title}</a></td>";
                echo "<td>{$author}</td>";
                echo "<td>";
                    $category->id = $category_id;
                    $category->readName();
                    echo $category->name;
                echo "</td>";
                // echo "<td><input type='checkbox' name='selected_books[]' value='$id'></td>";

  
                echo "<td>";

                    echo "<a href='read_one.php?id={$id}' class='btn btn-primary left-margin'>
                    View
                    </a>

                    <a href='update_book.php?id={$id}' class='btn btn-info left-margin'>
                    Edit
                    </a>

                    <a href='delete_book.php?id={$id}' class='btn btn-danger delete-object' onclick='return confirmDelete();'>
                    Delete
                    </a>";
                echo "</td>";
  
            echo "</tr>";
  
        }
  
    echo "</table>";
  
    // paging buttons will be here
}
  
// tell the user there are no books
else{
    echo "<div class='alert alert-info'>No books found.</div>";
}


?>




<?php


// the page where this paging is used
$page_url = "index.php?";
$total_rows = $book->countAll();
include_once('../pagination.php');
include_once('../resources/templates/footer.php');
?>

