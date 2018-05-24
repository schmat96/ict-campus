<?php 
if (session_status() != PHP_SESSION_ACTIVE) {
    session_start(); 
}

include_once 'resources/builder.php';

$temp = trim($_SERVER['REQUEST_URI'], '/');
$temp = explode('?', $temp);
$url = explode('/', $temp[0]);

$urlNumber = 3;

$realSpotClientID = "93c879989fe34da8a5d624dd56999a72";
$realSpotClientSecret = "3feb65fe08ff46279d15c3ed25051577";
$realSpotUrl = "http://localhost/SpotEasy2/ict-campus/SpotEasy/";
// views/resolveSpoitifyIDs.php anpassen
// database.php anpassen
// Spotify Developers, Redirects sind deine $realSpotURL + ["scan", "resolve", addplaylist "scanning"]!

$deepness = count($url) - $urlNumber;
if ($deepness > 1 ) {
    header('Location: '.$realSpotUrl.'home');
}


if (!empty($url[$urlNumber])) {
    $url[$urlNumber] = strtolower($url[$urlNumber]);
    switch($url[$urlNumber]) {
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
        case 'scan':
            require_once 'php/language.php';
            require_once 'php/scan.php';
            break;
        case 'manually':
            build('manually.php');
            break;
        case 'songlist':
            build('songList.php');
            break;
        case 'registercheck':
            require_once './php/register.php';
            registerCheck();
            break;
        case 'mancheck':
            require_once './php/mancheck.php';
            manCheck();
            break;
        case 'logincheck':
            require_once './php/logincheck.php';
            loginCheck();
            break;
        case 'logout':
            require_once './php/logout.php';
            logout();
            break;
        case 'savesession':
            require_once './php/saveSessionVariables.php';
            break;
        case 'dammed':
            require_once 'php/vendor/autoload.php';
            require_once 'php/spotifySearch.php';
            break;
        case 'updatebewertung':
            require_once './php/updateBewertung.php';
            break;
        case 'deletesong':
            require_once './php/deleteUserSong.php';
            break;
        case 'resolve':
            build('resolveSpotifyIDs.php');
            break;
        case 'updatespotid':
            require_once './php/updateSpotifyID.php';
            break;
        case 'addplaylist':
            require_once './php/addPlaylist.php';
            break;
        case 'scanning':
            require_once './php/scanning.php';
            break;
        case 'onthissitescanned':
            build('scannedResults.php');
            break;
        case 'prasi1':
            build('prasi1.php');
            break;
        case 'prasi2':
            build('prasi2.php');
            break;
        default:
            build('home.php', '1');
            break;  
    }
} else {
    build('home.php', '1');
}


?>
