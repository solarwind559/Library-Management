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
  
$records_per_page = 100;
  
$from_record_num = ($records_per_page * $page) - $records_per_page;
  
$page_title = "Book Borrowing";

include_once('header.php');
include_once('../../app/Controller/BookController.php');
include_once('../../app/Controller/UserController.php');

$database = new Database();
$db = $database->getConnection();

$user = new UserController($db);
$bookView = new BookController($db);
$bookView->showBorrowedBooks();
$book = new Book($db);

$stmt = $bookView->showBorrowedBooks();
$stmt2 = $user->viewAll($from_record_num, $records_per_page);
$stmt3 = $book->readAll($from_record_num, $records_per_page);

if (isset($_POST['user_id']) && isset($_POST['book_id'])) {
    $user_id = $_POST['user_id'];
    $book_id = $_POST['book_id'];
    $bookView->borrowBook($user_id, $book_id);
    } 
?>

<div class="container mt-3">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <div class="row">
            <div class="col-6">
            <?php 
                echo "<select id='user_select' name='user_id' required class='btn btn-light w-100'>";
                echo "<option value=''>Select a user...</option>";

                while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    echo "<option value='$id'>$name $surname ($email)</option>";
                }

                echo "</select>";
            ?>
            </div>
            <div class="col-6">
            <?php 
                echo "<select id='book_select' name='book_id' required class='btn btn-light w-100'>";
                echo "<option value=''>Select a book...</option>";

                while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    echo "<option value='$id'>$title ($author)</option>";
                }

                echo "</select>";
            ?>
            </div>
        </div><!--.row-->
        <input type="submit" value="Assign Book" class="btn btn-primary d-block mx-auto mt-4 mb-5">
    </form>    
</div><!--.container -->

<?php
    if ($stmt->rowCount() > 0) {
        echo "<table class='table table-striped'>";
        echo "<tr scope='row' class='table-dark'><th>Borrowed Book</th><th>Borrowed by</th><th>Borrow Date</th><th>Return Date</th></tr>";
        echo "<tr scope='row' class='table-primary'><th>Book Title:</th><th>Full Name:</th><th></th><th></th></tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr scope='row'>";
            echo "<td>" . $row['title'] . "</td>";
            echo "<td>" . $row['full_name'] . "</td>";
            echo "<td>" . $row['borrow_date'] . "</td>";
            echo "<td>" . $row['return_date'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No borrowed books found.";
    }
?>

<?php

$page_url = "?";
// $total_rows = $book->countAll();
// include_once('../../pagination.php');
//include the script
include_once('../partials/footer.php');
?>

