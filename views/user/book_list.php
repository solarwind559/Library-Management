<?php

session_start();

// Check if the user is authenticated
if (!isset($_SESSION['user_id'])) {
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

// get database connection
$database = new Database();
$db = $database->getConnection();
  
// pass connection to objects
$book = new Book($db);
$category = new Category($db);

// query books
$stmt = $book->readAll($from_record_num, $records_per_page);
$num = $stmt->rowCount();

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

$rows = [];  // Initialize an empty array to store the rows

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $rows[] = $row;  // Append each fetched row to the $rows array
}

// Sort the rows based on the specified column and order
usort($rows, function ($row1, $row2) use ($sort_column, $sort_order) {
    return compare_rows($row1, $row2, $sort_column, $sort_order);
});

if ($num > 0) {

    echo "<table class='table table-hover table-responsive table-bordered' id='categoryTable'>";
    echo "<tr>";
    echo "<th class='table-dark'><a href='?sort=title&order=" . ($sort_column === 'title' ? ($sort_order === 'asc' ? 'desc' : 'asc') : 'asc') . "'>Title &#8593;&#8595;</a></th>";
    echo "<th class='table-dark'><a href='?sort=author&order=" . ($sort_column === 'author' ? ($sort_order === 'asc' ? 'desc' : 'asc') : 'asc') . "'>Author &#8593;&#8595;</a></th>";
    echo "<th class='table-dark'><a href='?sort=category_name&order=" . ($sort_column === 'category_name' ? ($sort_order === 'asc' ? 'desc' : 'asc') : 'asc') . "'>Category &#8593;&#8595;</a></th>";
    echo "<th class='table-dark'><a href='?sort=status&order=" . ($sort_column === 'status' ? ($sort_order === 'asc' ? 'desc' : 'asc') : 'asc') . "'>Status &#8593;&#8595;</a></th>";
    echo "<th class='table-dark'></th>";
    echo "</tr>";

    foreach ($rows as $row) {

        extract($row);  // Extract values from the $row array
        
        $status_message = ($row['status'] == 1) ? "<i class='text-danger'>Borrowed</i>" : "<i class='text-success'>Available</i>";
        echo "<tr>";
        echo "<td><a href='read_one.php?id={$row['id']}'>{$row['title']}</a></td>";
        echo "<td>{$row['author']}</td>";
        echo "<td>";

        // category:
            $category->id = $category_id;
            $category->readName();
            $name = $category->name;

        echo $name;
        echo "</td>";

        echo "<td>{$status_message}</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No data found in database.";
}

$page_url = "?";
$total_rows = $book->countAll();
include_once('../../pagination.php');
//include the script
include_once('../partials/footer.php');
?>
