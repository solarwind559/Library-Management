<?php
$page_title = "View user Info";

include_once('header.php');
include_once(__DIR__ . '/../../app/Controller/UserController.php');

$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

$database = new Database();
$db = $database->getConnection();
  
$user = new UserController($db);
// $category = new Category($db);
  
// set ID property of user to be edited
$user->id = $id;
  
// read the details of user to be edited
$user->viewOne();

?>

<?php
    // Check if the HTTP_REFERER is set
    if (isset($_SERVER['HTTP_REFERER'])) {
        $referrer = $_SERVER['HTTP_REFERER'];
        echo '<a href="' . $referrer . '"><button class="btn btn-primary">Go Back</button></a><br><br>';
    } else {
        echo 'No referrer found.';
    }
?>

<?php

// HTML table for displaying a user details
echo "<table class='table table-hover table-bordered'>
  
    <tr>
        <th class='col-4'>Title</th>
        <td class='col-8'>{$user->name}</td>
    </tr>
  
    <tr>
        <th class='col-4'>Author</th>
        <td class='col-8'>{$user->surname}</td>
    </tr>
  
    <tr>
        <th class='col-4'>Email</th>
        <td class='col-8'>{$user->email}</td>
    </tr>

    <tr>
        <th class='col-4'>Books in Possession</th>";
            echo "<td>{$user->book_names}</td>";
    echo "</tr>
</table>";
?>
