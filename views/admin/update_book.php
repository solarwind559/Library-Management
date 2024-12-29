<?php
$page_title = "Edit Book Info";
include_once('header.php');
include_once(__DIR__ . '/../../app/Controller/BookController.php');

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

// if the form was submitted
if ($_POST) {
    // Check if the form is for updating book details
    if (isset($_POST['title'], $_POST['author'], $_POST['category_id'])) {
        // set book property values
        $book->title = $_POST['title'];
        $book->author = $_POST['author'];
        $book->category_id = $_POST['category_id'];

        // update the book
        if ($book->update()) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            The book information was updated successfully.
            </div>';
        } else {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Unable to update book information.
            </div>';
        }
    }

    // Check if the toggle button was clicked
    // if (isset($_POST['toggle'])) {
    //     // Perform toggle action
    //     if ($book->update()) {
    //         echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    //         The book information was updated successfully.
    //         </div>';
    //     } else {
    //         echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //         Unable to update book information.
    //         </div>';
    //     }
    // }
}

echo '<a href="book_list"><button class="btn btn-primary">Go Back</button></a><br><br>';

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
