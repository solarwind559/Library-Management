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
include_once('../../app/Controller/UserController.php');

// get database connection
$database = new Database();
$db = $database->getConnection();
  
// pass connection to objects
$book = new Book($db);
$category = new Category($db);
$user = new UserController($db);
$viewUser = $user->viewOne();
$_SESSION['name'] = $user->name;
$_SESSION['surname'] = $user->surname;

$name = $_SESSION['name'];

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
var_dump($userDetails['borrow_date']);

?>

<h2 class="mt-5">Welcome, <?php echo $userDetails['name'] ." ". $userDetails['surname']; ?>!</h2>

<div class="pt-5 library-info">
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
        if ($userDetails['book_names']) {
            
            //convert strings to array to echo the book_names separately
            $string = $userDetails['book_names'];
            $separator = ",<br>";
            $bookNames = explode($separator, $string);
            $bookNameCount = count(array_filter($bookNames, 'is_string'));

            echo "<table class='table'>";
            echo "<tr>";
            echo "<th scope='col'>#</th>";
            echo "<th scope='col'>Book Name:</th>";
            echo "<th scope='col'>Borrow Date:</th>";
            echo "<th scope='col'>Return Date:</th>";
            echo "</tr>"; 

                for ($i = 0; $i < $bookNameCount; $i++) {
                    $bookNumber = $i + 1;
                    $bookName = $bookNames[$i];

                    if (!empty($bookName)) {
                        echo "<tbody>";
                        echo "<tr>";
                        echo "<td><b>" . $bookNumber . ". </b></td>";
                        echo "<td>" . $bookName . "</td>";
                        echo "<td>" . $userDetails['borrow_date'] . "</td>";
                        echo "<td>" . $userDetails['return_date'] . "</td>";
                        echo "</tr>";
                        echo "</tbody>";
                    } else {
                    echo "Problem fetching user's details.";
                }
            }
            echo "</table>";
        } else {
            echo "Currently you have no borrowed books";
        }
    ?>
    </p>
</div>

<?php include_once('../partials/footer.php'); ?>