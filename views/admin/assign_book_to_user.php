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
// include_once '../../src/admin/return_book.php';

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
        <p class="list-up">&darr;	Please select a single user from the list:</p>
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
        <p class="list-up">&darr;	Please select up to 3 books from the list:</p>
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

<script>
    // JavaScript to handle button clicks and set hidden input values
    const userButtons = document.querySelectorAll('.user-button');
    const bookButtons = document.querySelectorAll('.book-button');
    const selectedUserIdInput = document.getElementById('selected-user-id');
    const selectedBookIdInput = document.getElementById('selected-book-id');

    userButtons.forEach(button => {
    button.addEventListener('click', () => {
        const isSelected = button.classList.contains('clicked-button');

        // Deselect all user buttons
        userButtons.forEach(btn => btn.classList.remove('clicked-button'));

        if (!isSelected) {
            // Toggle the .clicked-button class for the clicked button
            button.classList.add('clicked-button');
            selectedUserIdInput.value = button.getAttribute('data-user-id');
        } else {
            // If already selected, remove the selection
            selectedUserIdInput.value = ''; // Clear the selected user ID
        }
    });
});


    bookButtons.forEach(button => {
        button.addEventListener('click', () => {
            selectedBookIdInput.value = button.getAttribute('data-book-id');
            button.classList.toggle('clicked-button');
        });
    });

</script>




<?php

$page_url = "?";
// $total_rows = $book->countAll();
// include_once('../../pagination.php');
//include the script
include_once('../partials/footer.php');
?>
