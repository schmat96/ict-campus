<?php

/**
 * Fragt den User nach einem Auth-Token von Spotify. Schaut danach ob beim User ein Lied läuft. 
 * Falls ja, wird dieses in die Playlist eingefügt, falls Nein bekommt der User eine nette Meldung und kann
 * zurück nach HOME gelangen.
 */

/**
 * Überprüft ob der User eingeloggt ist.
 * #TODO Dies sollte eigentlich passieren bevor der User nach dem Spot-Auth-Token gefragt wird!
 */
require_once './php/checkUserLogin.php';
checkUserLogin();

$spoturl = $realSpotUrl."scan";
require 'php/vendor/autoload.php';
$session = new SpotifyWebAPI\Session(
    $realSpotClientID,
    $realSpotClientSecret,
    $spoturl
    );


$api = new SpotifyWebAPI\SpotifyWebAPI();

if (isset($_GET['code'])) {
    $session->requestAccessToken($_GET['code']);
    $_SESSION['spotifyCode'] = $_GET['code'];
    $api->setAccessToken($session->getAccessToken());
    
    /**
     * Gibt den Track, falls einer läuft, als JSON zurück. 
     * @var Ambiguous $result
     */
    $result = $api->getMyCurrentTrack();
    if ($result!=null) {
        $album = $result->item->album->name;
        $name = $result->item->name;
        $artist = $result->item->artists[0]->name;
        $spot_id = $result->item->id;
        
        $artistObject = $api->getArtist($result->item->artists[0]->id);
        /**
         * Fügt den Song in die DB ein-
         */
        require_once './php/databaseCRUD.php';
        $song_id = insertIntoSong($name, $artist, $album, $spot_id, $artistObject->genres);
        insertIntoUserSong($_SESSION['userID'], $song_id);
        
        
        header('Location: songlist');
    } else {
        echo "kein Song spielt im Moment auf diesem Account!";
        echo '<a href="home"> <h2 class="masthead-brand">Back to Home</h2></a>';
    }
    
} else {
    $options = [
        'scope' => [
            'user-read-currently-playing',
            'user-read-private'
        ],
    ];
    header('Location: ' . $session->getAuthorizeUrl($options));
    die();
}

?>