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

<div class="container mt-3">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" id="assign-form">
        <div class="row">
            <div class="col-6">
            <?php 
                echo "<select id='user_select' name='user_id' required class='btn btn-outline-primary w-100'>";
                echo "<option value=''>Select a user...</option>";

                while($row_user = $stmt2->fetch(PDO::FETCH_ASSOC)){
                    extract($row_user);
                    echo "<option value='$id'>$name $surname ($email)</option>";
                }

                echo "</select>";
            ?>
            </div>
            <div class="col-6">
            <?php   

                echo "<select id='book_select' name='book_id' required class='btn btn-outline-primary w-100'>";
                echo "<option value=''>Select a book...</option>";

                $foundRecords = false; // Initialize a flag

                while ($row_book = $stmt3->fetch(PDO::FETCH_ASSOC)) {               
                     $status = $row_book['status'];

                    if ($status === 0) {
                        
                        extract($row_book);
                        echo "<option value='$id'>$title ($author)</option>";
                        $foundRecords = true; // Set the flag to true
                    }
                }
                
                if (!$foundRecords) {
                    echo "<option value=''>No books available.</option>";
                }

                echo "</select>";
            ?>
            </div>
        </div><!--.row-->
        <input type="submit" value="Assign Book" class="btn btn-primary d-block mx-auto my-4">
    </form>    
</div><!--.container -->

<?php
    // if ($stmt->rowCount() > 0) {
    //     echo "<table class='table table-striped'>";
    //     echo "<tr scope='row' class='table-dark'><th>Borrowed Book:</th><th>Borrowed by:</th><th>Borrow Date:</th><th>Return Date:</th><th></th></tr>";
    //     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    //         echo "<tr scope='row'>";
    //         echo "<td>" . $row['title'] . "</td>";
    //         echo "<td>" . $row['full_name'] . "</td>";
    //         echo "<td>" . $row['borrow_date'] . "</td>";
    //         echo "<td>" . $row['return_date'] . "</td>";
    //         echo "<td> <a href='../../app/Controller/BookController.php?id={$id}' class='btn btn-outline-success'>Book Returned</a></td>";
    //         echo "</tr>";
    //     }
    //     echo "</table>";
    // } else {
    //     echo "No borrowed books found.";
    // }


?>

<?php
if ($stmt->rowCount() > 0) {

    if (isset($_GET['success']) && $_GET['success'] == 1) {
        echo "<div class='alert alert-success' role='alert'>
            Book was returned successfully.
        </div>";
    }

    echo "<table class='table table-striped'>";
    echo "<tr scope='row' class='table-dark'><th>Borrowed Book:</th><th>Borrowed by:</th><th>Borrow Date:</th><th>Return Date:</th><th></th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row); // Extract the values from the fetched row

        echo "<tr scope='row'>";
        echo "<td>{$title}</td>";
        echo "<td>{$full_name}</td>";
        echo "<td>{$borrow_date}</td>";
        echo "<td>{$return_date}</td>";
        echo "<td>
            <form action='../../src/admin/return_book.php' method='post' id='return-form'>
                <input type='hidden' name='return-form' value='return-form'>
                <input type='hidden' name='book_id' value='{$book_id}'>
                <button class='btn btn-outline-success' type='submit' value='confirmBookReturn();'>Book Returned</button>
            </form>
        </td>";
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

