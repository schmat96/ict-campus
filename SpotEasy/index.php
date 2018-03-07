<?php 
if (session_status() != PHP_SESSION_ACTIVE) {
    session_start(); 
}

include_once './resources/builder.php';

$temp = trim($_SERVER['REQUEST_URI'], '/');
$temp = explode('?', $temp);
$url = explode('/', $temp[0]);


if (!empty($url[3])) {
    $url[1] = strtolower($url[1]);
    switch($url[3]) {
        case 'login':
            build('login.php', '9');
            break;
        case 'about':
            build('about.php', '10');
            break;
        case 'dbform':
            build('datenbankForm.php');
            break;
        case 'register':
            build('register.php');
            break;
            
        case 'registerCheck':
            require_once './php/register.php';
            registerCheck();
            break;
        default:
            build('home.php', '1');
            break;
           
    }
} else {
    build('');
}


?>