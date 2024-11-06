<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../../public/assets/css/main.css">

</head>
<body>

<?php

include_once(__DIR__ . '/../../config/db.php');

include_once(__DIR__ . '/../../app/Model/Book.php');

include_once(__DIR__ . '/../../app/Model/Category.php');


$currentFile = basename($_SERVER['PHP_SELF']);

?>

<header style="">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6 py-3 my-auto">
                <a href="dashboard"><img src="../../public/assets/img/Book_blue.svg" alt="logo"></a>             
            </div>
            <?php
                $currentFile = basename($_SERVER['PHP_SELF']);
                if ($currentFile !== 'login.php') {
                    echo '<navbar class="col-12 col-md-6 mt-2 text-end d-flex"><ul class="nav justify-content-end">';
                    echo '<li class="nav-item"><a class="nav-link" href="assign_book_to_user">Book Borrowing |</a></li> ';
                    echo '</ul>';
                    echo '<ul>';
                    echo '<li class="nav-item"><a class="nav-link" href="borrowed_books">Borrowed Book List |</a></li> ';
                    echo '<li class="nav-item"><a class="nav-link" href="book_list">Book List |</a></li> ';
                    echo '<li class="nav-item"><a class="nav-link" href="user_list">User List |</a></li> ';
                    echo '</ul>';
                    echo '<ul>';
                    echo '<li class="nav-item"><a class="nav-link active" href="register_user.php">Add New User |</a></li> ';
                    echo '<li class="nav-item"><a class="nav-link active" href="create_book.php">Add New Book |</a></li> ';
                    echo '<li class="nav-item"><a class="nav-link" href="../../src/admin/admin_logout.php">Log Out |</a></li>';
                    echo '</ul></navbar>';
                }
            ?>

        </div>
    </div>
</header>
<body>

<div class="container">
    <div class='page-header pt-4 pb-3'>
        <h1><?php echo $page_title ?></h1>
    </div>