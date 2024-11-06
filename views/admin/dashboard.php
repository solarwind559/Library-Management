<?php

session_start();

// Check if the user is authenticated
if (!isset($_SESSION['admin_id'])) {
    // Redirect to the login page (adjust the URL as needed)
    header('Location: login');
    exit();
}
  
$page_title = "Librarian Dashboard";
include_once('header.php');
include_once(__DIR__ . '/../../app/Controller/UserController.php');
include_once(__DIR__ . '/../../app/Controller/BookController.php');
use App\Controllers\BookController;


// get database connection
$database = new Database();
$db = $database->getConnection();
  
// pass connection to objects
$book = new Book($db);
$category = new Category($db);
$user = new UserController($db);
$showBooks = new BookController($db);
$stmt = $showBooks->showBorrowedBooks();

// fetch the number of records in database
$bookCount = $book->countAll();
$userCount = $user->countAll();

?>

<h2 class="text-center mt-4">Current library statistics</h2>

<div class="row py-5 library-info">

    <div class="col-12 col-md-4 text-center mb-3 p-3">
      <a href="book_list" class="icon">
        <?php include_once('../../public/assets/img/book_icon.svg'); ?>    
        <p class="span-number my-2"><?php echo $bookCount; ?></p>
        <p>BOOKS</p>
      </a>
    </div>

    <div class="col-12 col-md-4 text-center mb-3 p-3">
      <a href="user_list" class="icon">
    	<?php include_once('../../public/assets/img/users_icon.svg'); ?>    
        <p class="span-number my-2"><?php echo $userCount; ?> </p>
        <p>USERS</p>
      </a>
    </div>

    <div class="col-12 col-md-4 text-center mb-3 p-3">
       <a href="borrowed_books" class="icon">
    	<?php include_once('../../public/assets/img/exclamation_icon.svg'); ?>    
        <p class="span-number my-2">
            
            <?php
            // get number of rows with date earlier than current date        
            $currentDate = date('Y-m-d');
            $earlierRowsCount = 0; // Counter variable

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // check if current date has not passed
                if ($row['return_date'] < $currentDate) { 
                    $earlierRowsCount++; // Increment the counter
                }
            }

            echo $earlierRowsCount;
            ?> 

        </p>         
        <p>BOOKS OVERDUE</p>
       </a>
    </div>

</div>

<?php include_once('../partials/footer.php');?>

