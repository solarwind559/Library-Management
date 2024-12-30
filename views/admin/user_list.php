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
  
$page_title = "Browse Users";

include_once('header.php');
include_once('../../app/Controller/UserController.php');

// get database connection
$database = new Database();
$db = $database->getConnection();
  
// pass connection to objects
$book = new Book($db);
$user = new UserController($db);

// query users
$stmt = $user->viewAll($from_record_num, $records_per_page);
$num = $stmt->rowCount();

// include sort functionality
$sort_column = isset($_GET['sort']) ? $_GET['sort'] : 'name';
$sort_order = isset($_GET['order']) ? $_GET['order'] : 'asc';

// Define a function to compare rows based on the sorting column
function compare_rows($row1, $row2, $sort_column, $sort_order) {
    if ($sort_order === 'asc') {
        return strnatcasecmp($row1[$sort_column], $row2[$sort_column]);
    } else {
        return strnatcasecmp($row2[$sort_column], $row1[$sort_column]);
    }
}

$rows = [];  // Initialize an empty array to store the rows


while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $rows[] = $row;  // Append each fetched row to the $rows array
}

// Sort the rows based on the specified column and order
usort($rows, function ($row1, $row2) use ($sort_column, $sort_order) {
    return compare_rows($row1, $row2, $sort_column, $sort_order);
});


if($num>0){
  
    echo "<div class='table-responsive'>";
    echo "<table class='table table-hover table-bordered'>";
        echo "<tr>";
            echo "<th class='table-dark'><a href='?sort=name&order=" . ($sort_column === 'name' ? ($sort_order === 'asc' ? 'desc' : 'asc') : 'asc') . "'>Name &#8593;&#8595;</a></th>"; 
            echo "<th class='table-dark'><a href='?sort=surname&order=" . ($sort_column === 'surname' ? ($sort_order === 'asc' ? 'desc' : 'asc') : 'asc') . "'>Surname &#8593;&#8595;</a></th>";
            echo "<th class='table-dark'><a href='?sort=email&order=" . ($sort_column === 'email' ? ($sort_order === 'asc' ? 'desc' : 'asc') : 'asc') . "'>Email &#8593;&#8595;</a></th>";
            echo "<th class='table-dark'>User Info</th>";
            echo "<th class='table-dark'>Books in possession</th>";      
        echo "</tr>";
  
            foreach ($rows as $row) {

                extract($row);  // Extract values from the $row array
                
            echo "<tr>";
                echo "<td>{$name}</td>"; 
                echo "<td>{$surname}</td>";
                echo "<td><a href='mailto:{$email}'>{$email}</a></td>";
                echo "<td class='text-center align-middle'>
                <a href='view_one_user.php?id={$id}' class='btn btn-outline-primary'>View</a> 
                <a href='update_user.php?id={$id}' class='btn btn-outline-info'>Edit</a>
                </td>";
                if ($books_in_possession){ // if user has a book assigned to them
                    echo "<td><i><a href='borrowed_books'>{$book_names}</a></i></td>"; // echo the name of the book
                } else {
                    echo "<td>-</td>";
                }
            echo "</tr>";
        }
    echo "</table>";
    echo "</div>";
}
    else {
        echo "<div class='alert alert-info'>No users found.</div>";
    }
?>

<?php
$page_url = "?";
$total_rows = $user->countAll();
include_once('../../pagination.php');

//include the script
include_once('../partials/footer.php');
?>