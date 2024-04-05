<?php
//test only:
// echo "Request URI: " . $_SERVER['REQUEST_URI'];

// $request = $_SERVER['REQUEST_URI'];
// $viewDir = '/views/';


// switch ($request) {
//     // case '/':
//     // require __DIR__ . '/public/index.php';
//     // break;

// case '/user/index':
//     require __DIR__ . $viewDir . 'user/index.php';
//     break;
// }

// echo "<br>this is index.php in the root folder";

define('PROJECT_ROOT', __DIR__); // Assumes index.php is in the root folder

?>