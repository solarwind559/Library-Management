<?php
$page_title = "Add Books";
include_once('header.php');

// get database connection
$database = new Database();
$db = $database->getConnection();
  
// pass connection to objects
$book = new Book($db);
$category = new Category($db);

// if the form was submitted
if($_POST){
  
    // set product property values
    $book->title = $_POST['title'];
    $book->author = $_POST['author'];
    $book->category_id = $_POST['category_id'];
  
    // create the product
    if($book->create()){
        echo "<div class='alert alert-success'>The book was created.</div>";
    }
  
    // if unable to create the product, tell the user
    else {
        echo "<div class='alert alert-danger'>Unable to create a new book.</div>";
    }
}
?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    

        <div class="mb-3">
            <label>Title</label>
            <td><input type='text' name='title' class='form-control' required /></td>
        </div>

        <div class="mb-3">
            <label>Author</label>
            <td><input type='text' name='author' class='form-control' required /></td>
        </div>

        <div class="mb-3">
            <label>Category</label>
            <?php
                // read the product categories from the database
                $stmt = $category->read();
                
                // put them in a select drop-down
                echo "<select class='form-control' name='category_id' required>";
                    echo "<option value='' disabled selected>Select category...</option>";
                
                    while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row_category);
                        echo "<option value='{$id}'>{$name}</option>";
                    }
                
                echo "</select>";
                ?>
        </div>

            <button type="submit" class="btn btn-primary">Create</button>

    </form>

<?php
include_once('../partials/footer.php');
?>

