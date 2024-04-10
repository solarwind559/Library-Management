<?php
$page_name = "Edit Book";
include_once('header.php');
include_once('../../app/Controller/UserController.php');

// get ID of the book to be edited
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

// get database connection
$database = new Database();
$db = $database->getConnection();
  
// pass connection to objects
$book = new Book($db);
$user = new UserController($db);
  
// set ID property of book to be edited
$user->id = $id;
  
// read the details of book to be edited
$user->viewOne(); 



?>
<?php
    // Check if the HTTP_REFERER is set
    if (isset($_SERVER['HTTP_REFERER'])) {
        $referrer = $_SERVER['HTTP_REFERER'];
        echo '<a href="' . $referrer . '"><button>Go Back</button></a><br><br>';
    } else {
        echo 'No referrer found.';
    }
?>

<?php 
// if the form was submitted
if($_POST){
  
    // set book property values
    $user->name = $_POST['name'];
    $user->surname = $_POST['surname'];
    $user->email = $_POST['email'];
  
    // update the book
    if($user->update()){
        echo "<div class='alert alert-success alert-dismissable'>
            The book has been updated.
        </div>";
    }
  
    // if unable to update the book, tell the user
    else{
        echo "<div class='alert alert-danger alert-dismissable'>
            Unable to update book.
        </div>";
    }
}
?>  
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
        <table class='table table-hover table-responsive table-bordered'>
    
            <tr>
                <td>name</td>
                <td><input type='text' name='name' value='<?php echo $user->name; ?>' class='form-control' /></td>
            </tr>
    
            <tr>
                <td>surname</td>
                <td><input type='text' name='surname' value='<?php echo $user->surname; ?>' class='form-control' /></td>
            </tr>

    
            <tr>
                <td></td>
                <td>
                    <button type="submit" class="btn btn-primary">Update</button>
                </td>
            </tr>
    
        </table>
    </form>    