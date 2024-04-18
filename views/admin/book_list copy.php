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

//sorting
// Assuming you want to sort the table based on the "Title" and "Author" columns

// Get the sorting column and order from the query parameters
$sort_column = isset($_GET['sort']) ? $_GET['sort'] : 'title';
$sort_order = isset($_GET['order']) ? $_GET['order'] : 'asc';

// Define a function to compare rows based on the sorting column
function compare_rows($row1, $row2, $sort_column, $sort_order) {
    if ($sort_order === 'asc') {
        return strnatcasecmp($row1[$sort_column], $row2[$sort_column]);
    } else {
        return strnatcasecmp($row2[$sort_column], $row1[$sort_column]);
    }
}

// Assuming you have an array of rows (e.g., fetched from the database)
$rows = [];  // Initialize an empty array to store the rows

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $rows[] = $row;  // Append each fetched row to the $rows array
}

// Sort the rows based on the specified column and order
usort($rows, function ($row1, $row2) use ($sort_column, $sort_order) {
    return compare_rows($row1, $row2, $sort_column, $sort_order);
});

// Print the sorted table
echo "<table class='table table-hover table-responsive table-bordered'>";
echo "<tr>";
echo "<th class='table-dark'><a href='?sort=title&order=" . ($sort_column === 'title' ? ($sort_order === 'asc' ? 'desc' : 'asc') : 'asc') . "'>Title</a></th>";
echo "<th class='table-dark'><a href='?sort=author&order=" . ($sort_column === 'author' ? ($sort_order === 'asc' ? 'desc' : 'asc') : 'asc') . "'>Author</a></th>";
echo "<th class='table-dark'>Category</th>";
echo "<th class='table-dark'>Status</th>";
echo "<th class='table-dark'></th>";
echo "</tr>";

foreach ($rows as $row) {
    extract($row);  // Extract values from the $row array

    $status_message = ($row['status'] == 1) ? "<b style='color:#dc3545;'>Borrowed</b>" : "<b style='color:#198754;'>Available</b>";
    echo "<tr>";
    echo "<td><a href='read_one.php?id={$row['id']}'>{$row['title']}</a></td>";
    echo "<td>{$row['author']}</td>";
    echo "<td>{$category_id}</td>";  // Use the extracted variable
    echo "<td>{$status_message}</td>";
    echo "<td>";
    echo "<a href='read_one.php?id={$row['id']}' class='btn btn-outline-primary left-margin'>View</a>";
    echo "<a href='update_book.php?id={$row['id']}' class='btn btn-outline-info left-margin'>Edit</a>";
    echo "<a href='../../src/admin/delete_book.php?id={$row['id']}' class='btn btn-outline-danger delete-object' onclick='return confirmDelete();'>Delete</a>";
    echo "</td>";
    echo "</tr>";
}

echo "</table>";

//$page_url = "dashboard.php?";
$page_url = "?";
$total_rows = $book->countAll();
include_once('../../pagination.php');
//include the script
include_once('../partials/footer.php');
?>

