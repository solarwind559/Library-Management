<?php
session_start();

// Check if the user is authenticated
if (!isset($_SESSION['admin_id'])) {
    // Redirect to the login page
    header('Location: login');
    exit();
}

// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;
  
$records_per_page = 100;
  
$from_record_num = ($records_per_page * $page) - $records_per_page;
  
$page_title = "Book Borrowing";

include_once('header.php');
include_once(__DIR__ . '/../../app/Controller/UserController.php');
include_once(__DIR__ . '/../../app/Controller/BookController.php');
use App\Controllers\BookController;

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
<form action="" method="POST" id="assign-form">                
    <div class="row">
        <div class="col-6">
        <table class="table table-striped table-custom">
        <p class="list-up">&darr;	Please select a user from the list:</p>
                <tbody>
                    <th class='table-dark'>User</th>
                    <?php
                    while ($row_user = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                        extract($row_user);
                        echo "<tr>";
                        echo "<td><button type='button' class='user-button btn w-100 text-start' data-user-id='$id'>$name $surname ($email)</button></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="col-6">
        <table class="table table-striped table-custom">
        <p class="list-up">&darr;	Please select a book from the list:</p>
                <tbody>
                    <th class='table-dark'>Book</th>
                    <?php
                    $foundRecords = false;

                    while ($row_book = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                        extract($row_book);
                        $status = $row_book['status'];

                        if ($status === 0) {
                            echo "<tr>";
                            echo "<td><button type='button' class='book-button btn w-100 text-start' data-book-id='$id'>$title ($author)</button></td>";
                            echo "</tr>";
                            $foundRecords = true;
                        }
                    }

                    if (!$foundRecords) {
                        echo "<tr><td>No books available.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <input type="hidden" name="user_id" id="selected-user-id">
        <input type="hidden" name="book_id" id="selected-book-id">
        <input type="submit" value="Assign Book" class="btn btn-primary d-block mx-auto my-4 w-50">
    </div>
</form>

<!-- Button functionality -->
<script src="../../public/assets/js/buttons.js"></script>

<?php

$page_url = "?";
//include the script
include_once('../partials/footer.php');
?>