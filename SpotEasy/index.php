<?php 
include_once './resources/builder.php';

$temp = trim($_SERVER['REQUEST_URI'], '/');
$url = explode('/', $temp);

if (!empty($url[3])) {
    $url[1] = strtolower($url[1]);
    switch($url[3]) {
        case 'login':
            build('login.php');
            break;
        case 'about':
            build('about.php');
            break;
        case 'dbform':
            build('datenbankForm.php');
            break;
        default:
            build('home.php');
            break;
           
    }
} else {
    build('');
}


?>