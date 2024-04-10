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
include_once('../../config/db.php');
include_once('../../app/Model/Book.php');
include_once('../../app/Model/Category.php');



    $currentFile = basename($_SERVER['PHP_SELF']);

    // $imagePathLogin = '<img src="../public/assets/img/Vector_Book_blue.svg" alt="logo">';
    // $imagePathOther = '<img src="../../public/assets/img/Vector_Book_blue.svg" alt="logo">';

    ?>

<header style="">
    <div class="container">
        <div class="row">
            <div class="col-8 py-3">
                <?php
                // if ($currentFile === 'login.php'){
                //    echo $imagePathLogin;        

                // } else {
                //     echo $imagePathOther;            
                // } 
                ?>
                <a href="dashboard"><img src="../../public/assets/img/Vector_Book_blue.svg" alt="logo"></a>             
            </div>
            <?php
                $currentFile = basename($_SERVER['PHP_SELF']);
                if ($currentFile !== 'login.php') {
                    echo '<navbar class="col-4 my-auto text-end"><ul>';
                    echo '<li><a href="register_user.php">Add New User</a></li> ';
                    echo '<li><a href="user_list.php">User List</a></li> ';
                    echo '<li><a href="../../src/admin/admin_logout.php">Log Out</a></li>';
                    echo '</ul></navbar>';
                };
            ?>

        </div>
    </div>
</header>
<body>

<div class="container">
    <div class='page-header pt-4 pb-3'>
        <h1><?php echo $page_title ?></h1>
    </div>