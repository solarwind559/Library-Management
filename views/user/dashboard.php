<?php

session_start();

// Check if the user is authenticated
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page (adjust the URL as needed)
    header('Location: login');
    exit();
}

$page_title = "Student Dashboard";
include_once('header.php');
include_once(__DIR__ . '/../../app/Controller/UserController.php');
include_once(__DIR__ . '/../../app/Controller/BookController.php');
use App\Controllers\BookController;

//include_once('../../app/Controller/UserController.php');
//include_once('../../app/Controller/BookController.php');

// get database connection
$database = new Database();
$db = $database->getConnection();
  
// pass connection to objects
$book = new Book($db);
$category = new Category($db);
$user = new UserController($db);
$viewUser = $user->viewOne();
$showBooks = new BookController($db);
$stmt = $showBooks->showBorrowedBooks();

// Check if the session variables are set

if (isset($_SESSION['user_id'])){
    $user = new UserController($db);
    // Set the id to the $user_id value
    $user->id = $_SESSION['user_id'];
    // Call the viewOne() method to fetch the user details
    $userDetails = $user->viewOne();
} else {
    echo "Session variables are not set. Please log in.";
}

?>

<h2 class="mt-5">Welcome, <?php echo $userDetails['name'] ." ". $userDetails['surname']; ?>!</h2>

<div class="py-5 library-info">
    <h4 class="">You have checked out <b class="text-danger">
    <?php
        //convert strings to array to echo the number of strings for our book_names
        $array = explode(",", $userDetails['book_names']);

        if ($userDetails['book_names']) {
            $bookCount = count(array_filter($array, 'is_string'));
            echo $bookCount;
        } else {
            echo " 0 ";
        }
    ?> 
    </b> books</h4>

<?php

// echo the table

if ($stmt->rowCount() > 0) {

    $currentDate = date('Y-m-d');
    $overdueCount = 0;

    // First loop to count overdue books
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($_SESSION['user_id'] === $row['user_id'] && $row['return_date'] <= $currentDate) {
            $overdueCount++;
        }
    }

    // Display the overdue message before the table
    if ($overdueCount > 0) {
        if ($overdueCount == 1) {
            echo "<div class='alert alert-danger mt-3' role='alert'>You have 1 overdue book. Please return it to the library as soon as possible. Thank you!</div>";
        } else {
            echo "<div class='alert alert-danger mt-3' role='alert'>You have $overdueCount overdue books. Please return them to the library as soon as possible. Thank you!</div>";
        }
    }

    // Reset the statement cursor for the second loop
    $stmt->execute();

    echo "<table class='table mt-4'>";
        echo "<tr>";
        echo "<th class='table-dark'>Book Names</th>";
        echo "<th class='table-dark'>Borrow Date</th>";
        echo "<th class='table-dark'>Return Date</th>";
        echo "</tr>";

        // Second loop to display the table
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($_SESSION['user_id'] === $row['user_id']) {
                if ($row['return_date'] > $currentDate) { 
                    echo "<tr>";
                    echo "<td>" . $row['book_name'] . "</td>";
                    echo "<td>" . $row['borrow_date'] . "</td>";
                    echo "<td>" . $row['return_date'] . "</td>";
                    echo "</tr>";
                } else {
                    echo "<tr class='text-danger'>";
                    echo "<td>" . $row['book_name'] . "</td>";
                    echo "<td>" . $row['borrow_date'] . "</td>";
                    echo "<td>" . $row['return_date'] . " | <b>BOOK OVERDUE</b></td>";
                    echo "</tr>";
                }
            }
        }
    echo "</table>";
}

?>


</div>

<?php include_once('../partials/footer.php'); ?>