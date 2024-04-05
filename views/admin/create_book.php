<?php
$page_title = "Add Books";
include_once('header.php');

// get database connection
$database = new Database();
$db = $database->getConnection();
  
// pass connection to objects
$book = new Book($db);
$category = new Category($db);

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


// if the form was submitted - PHP OOP CRUD Tutorial
if($_POST){
  
    // set product property values
    $book->title = $_POST['title'];
    $book->author = $_POST['author'];
    $book->category_id = $_POST['category_id'];
  
    // create the product
    if($book->create()){
        echo "<div class='alert alert-success'>Product was created.</div>";
    }
  
    // if unable to create the product, tell the user
    else{
        echo "<div class='alert alert-danger'>Unable to create product.</div>";
    }
}
?>
    <!-- HTML form for creating a product -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    

        <div class="mb-3">
            <label>Title</label>
            <td><input type='text' name='title' class='form-control' /></td>
        </div>

        <div class="mb-3">
            <label>Author</label>
            <td><input type='text' name='author' class='form-control' /></td>
        </div>

        <div class="mb-3">
            <label>Category</label>
            <!-- categories from database will be here -->
            <?php
                // read the product categories from the database
                $stmt = $category->read();
                
                // put them in a select drop-down
                echo "<select class='form-control' name='category_id'>";
                    echo "<option>Select category...</option>";
                
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

