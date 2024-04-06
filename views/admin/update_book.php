<?php
$page_title = "Edit Book";
include_once('header.php');
// get ID of the book to be edited
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

// get database connection
$database = new Database();
$db = $database->getConnection();
  
// pass connection to objects
$book = new Book($db);
$category = new Category($db);
  
// set ID property of book to be edited
$book->id = $id;
  
// read the details of book to be edited
$book->readOne(); 



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
    $book->title = $_POST['title'];
    $book->author = $_POST['author'];
    $book->category_id = $_POST['category_id'];
  
    // update the book
    if($book->update()){
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
                <td>Title</td>
                <td><input type='text' name='title' value='<?php echo $book->title; ?>' class='form-control' /></td>
            </tr>
    
            <tr>
                <td>Author</td>
                <td><input type='text' name='author' value='<?php echo $book->author; ?>' class='form-control' /></td>
            </tr>
    
    
            <tr>
                <td>Category</td>
                <td>
                <?php
                    $stmt = $category->read();
                    
                    // put them in a select drop-down
                    echo "<select class='form-control' name='category_id'>";
                    
                        echo "<option>Please select...</option>";
                        while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)){
                            $category_id=$row_category['id'];
                            $category_name = $row_category['name'];
                    
                            // current category of the book must be selected
                            if($book->category_id==$category_id){
                                echo "<option value='$category_id' selected>";
                            }else{
                                echo "<option value='$category_id'>";
                            }
                    
                            echo "$category_name</option>";
                        }
                    echo "</select>";
                    ?>
                </td>
            </tr>
    
            <tr>
                <td></td>
                <td>
                    <button type="submit" class="btn btn-primary">Update</button>
                </td>
            </tr>
    
        </table>
    </form>    
