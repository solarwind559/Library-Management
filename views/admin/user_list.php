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
  
$page_title = "Browse users";
include_once('header.php');

include_once('../../app/Controller/UserController.php');

// get database connection
$database = new Database();
$db = $database->getConnection();
  
// pass connection to objects
$book = new Book($db);
$user = new UserController($db);

// $category = new UserController($db);

// query users
$stmt = $user->viewAll($from_record_num, $records_per_page);
$num = $stmt->rowCount();

if($num>0){
  
    echo "<table class='table table-hover table-responsive table-bordered'>";
        echo "<tr>";
            echo "<th>Name</th>";
            echo "<th>Surname</th>";
            echo "<th>Email</th>";
            echo "<th>Books in posession</th>";
            
        echo "</tr>";
  
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  
            extract($row);
            echo "<tr>";
                echo "<td>{$name}</td>"; 
                echo "<td>{$surname}</td>";
                echo "<td>{$email}</td>";
                echo "<td><a href='update_user.php?id={$id}' class='btn btn-info left-margin'>
                Edit
                </a></td>";
            echo "</tr>";
        }
    echo "</table>";
  
    // paging buttons will be here
}
  
// tell the user there are no users
else{
    echo "<div class='alert alert-info'>No users found.</div>";
}
?>

<?php
//$page_url = "dashboard.php?";
$page_url = "?";
$total_rows = $user->countAll();
include_once('../../pagination.php');
//include the script
include_once('../partials/footer.php');
?>