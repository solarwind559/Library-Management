<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="resources/css/main.css">

</head>
<body>

<header style="">
    <div class="container">
        <div class="row">
            <div class="col-8 py-3">
            <?php include('../public/assets/img/Vector_Book_blue.svg'); ?>
            </div>
            <div class="col-4">
                <ul class="d-flex justify-content-between">
                    <a href="/"><li>LOG IN</li></a>
                    <a href="/register"><li>REGISTER</li></a>
                    
                </ul>
            
            
            </div>

        </div>
    </div>
</header>
<body>

<div class="container">
    <div class='page-header pt-4 pb-3'>
        <h1><?php echo $page_title ?></h1>
    </div>