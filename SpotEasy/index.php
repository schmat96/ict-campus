<?php 
include_once './resources/builder.php';

$temp = trim($_SERVER['REQUEST_URI'], '/');
$url = explode('/', $temp);

if (!empty($url[1])) {
    $url[1] = strtolower($url[1]);
    switch($url[1]) {
        case 'login':
            build('login.php');
            break;
        case 'about':
            build('about.php');
            break;
        default:
            build('home.php');
            break;
           
    }
} else {
    build('home.php');
}


?>