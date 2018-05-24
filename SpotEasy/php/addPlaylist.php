<?php

/**
 * Hier wird überprüft ob die Variabeln gesetzt wurden. Da wir mit der Spotify-API arbeiten und diese weiterleiten, können wir
 * keine POST Variabeln beim 2ten Redirect verwenden und müssen Darum diese Daten beim ersten Aufruf in $_SESSION-Variabeln
 * speichern. Sind beide Variabeln nicht gesetzt, hat man hier nichts zu suchen und wir zürock zu Home geleitet.
 * 
 * @param $_POST['name'] - string: Name der neuen Playlist. Ist diese Leer wird ein Standard Parameter gewählt.
 * @param $_POST['loeschen'] - bool: Ob die Playlist danach gelöscht werden soll oder nicht.
 * @param $_POST['berechtigungen'] - bool: Ob die Playlist privat oder public sein soll
 */
if (isset($_POST['name'])) {
    if ($_POST['name']=="") {
        $_SESSION['addPlaylistName'] = "SpotEasy";
    } else {
        $_SESSION['addPlaylistName'] = $_POST['name'];
    }
} else if (!isset($_SESSION['addPlaylistName']) && $_SESSION['addPlaylistName']!="") {
    header('Location: home');
}

if (isset($_POST['loeschen'])) {
    if ($_POST['loeschen']=="true") {
        $_SESSION['addPlaylistLoeschen'] = true;
    } else {
        $_SESSION['addPlaylistLoeschen'] = false;
    }
} else if (!isset($_SESSION['addPlaylistLoeschen'])) {
    header('Location: home');
}

if (isset($_POST['berechtigungen'])) {
    if ($_POST['berechtigungen']=="public") {
        $_SESSION['addPlaylistBerechtigungen'] = true;
    } else {
        $_SESSION['addPlaylistBerechtigungen'] = false;
    }
} else if (!isset($_SESSION['addPlaylistBerechtigungen'])) {
    header('Location: home');
}

/**
 * Macht eine
 * @var aus dem index.php, statische Variable:  $spoturl
 */
$spoturl = $realSpotUrl."addplaylist";
require 'php/vendor/autoload.php';
$session = new SpotifyWebAPI\Session(
    $realSpotClientID,
    $realSpotClientSecret,
    $spoturl
    );

$api = new SpotifyWebAPI\SpotifyWebAPI();


/**
 * In dieses IF kommt man, wenn man von Spotify den Auth Token bekommen hat. Entweder ist er also schon gesetzt
 * oder er muss zuerst geholt werden (-->ELSE).
 */
if (isset($_GET['code'])) {
    
    
    $session->requestAccessToken($_GET['code']);
    $api->setAccessToken($session->getAccessToken());

    /**
     * Die oben gennanten $_SESSION Variabeln werden korrekt in das Array options gesetzt. Danach mit der Klasse $api weiterverarbeitet.
     * @var array $options
     */
    $options = array("name" => $_SESSION['addPlaylistName'], "public" => $_SESSION['addPlaylistBerechtigungen']);
    $_SESSION['addPlaylistName'] = "";
    $_SESSION['addPlaylistBerechtigungen'] = "";
    
    $newPlaylist = $api->createUserPlaylist($api->me()->id, $options);
    
    /**
     * Die Datenbank-Abfrage für die Songs. Alle müssen die Spotify-ID gesetzt haben, ansonsten wäre das Form nicht erschienen.
     */
    require_once './php/databaseCRUD.php';
    $result = getSongList($_SESSION['userID']);
    
    $track = array();
    $tracksSongID = array();
    
    if ($result->num_rows > 0) {
        $zaehler = "0";
        /**
         * Um die Songs danach wieder löschen zu können, speichern wir die Spotify_ID sowie die song_id
         */
        while ($row = mysqli_fetch_object($result)) {
            array_push($track, $row->spotify_id);
            array_push($tracksSongID, $row->song_id);
        }
    }
    
    /**
     * Als erstes benötigen wir jedoch eine playlist.
     */  
    $api->addUserPlaylistTracks($api->me()->id, $newPlaylist->id, $track);
    
    /**
     * Haben wir die option gewählt, wird nun die Playlist auf SpotEasy geleert.
     */
    if ($_SESSION['addPlaylistLoeschen']) {
        foreach ($tracksSongID as $songID) {
            deleteUserSong($_SESSION['userID'],$songID);
        }
        
    }
    echo "nach delete songs";
    $_SESSION['addPlaylistLoeschen'] = "";
    
    header('Location: home');
    
    
} else {
    $options = [
        'scope' => [
            'playlist-modify-private',
            'playlist-modify-public',
            'user-read-email'
        ],
    ];
    
    header('Location: ' . $session->getAuthorizeUrl($options));
    die();
}

?>