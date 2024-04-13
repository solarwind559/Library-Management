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
  
// set number of records per page
$records_per_page = 7;
  
// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;
  
$page_title = "Browse Books";
include_once('header.php');

include_once '../../src/admin/delete_book.php';

// get database connection
$database = new Database();
$db = $database->getConnection();
  
// pass connection to objects
$book = new Book($db);
$category = new Category($db);

// query books
$stmt = $book->readAll($from_record_num, $records_per_page);
$num = $stmt->rowCount();



if($num>0){
  
    echo "<table class='table table-hover table-responsive table-bordered'>";
        echo "<tr>";
            echo "<th>Title</th>";
            echo "<th>Author</th>";
            echo "<th>Category</th>";
            echo "<th>Status</th>";
            echo "<th>Actions</th>";
            
        echo "</tr>";
  
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  
            extract($row);

            $status_message = ($status == 1) ? "<b style='color:#dc3545;'>Borrowed</b>" : "<b style='color:#198754;'>Available</b>";
  
            echo "<tr>";
                echo "<td><a href='read_one.php?id={$id}'>{$title}</a></td>";
                echo "<td>{$author}</td>";
                echo "<td>";
                    $category->id = $category_id;
                    $category->readName();
                    echo $category->name;
                echo "</td>";
                echo "<td>{$status_message}</td>";

                echo "<td>";

                    echo "<a href='read_one.php?id={$id}' class='btn btn-primary left-margin'>
                    View
                    </a>

                    <a href='update_book.php?id={$id}' class='btn btn-info left-margin'>
                    Edit
                    </a>

                    <a href='../../src/admin/delete_book.php?id={$id}' class='btn btn-danger delete-object' onclick='return confirmDelete();'>
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
//$page_url = "dashboard.php?";
$page_url = "?";
$total_rows = $book->countAll();
include_once('../../pagination.php');
//include the script
include_once('../partials/footer.php');
?>

