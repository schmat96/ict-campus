<?php

/**
 * Fragt den User nach einem Auth-Token von Spotify. Schaut danach welche letzen Lieder auf dem Account gelaufen sind.
 * Diese Lieder werden danach in die Datenbank gespeichert. Die ganze Funktion kann lange Dauern. Es werden viele Spotify Anfragen gemacht und
 * viele Updates/Selects auf der Datenbank.
 * Das ganze wurde optimiert mit der Variable Last Scanned auf dem tbl_user, kann aber sicher noch weiter optimiert werden!
 * 
 */

/**
 * Überprüft ob der User eingeloggt ist.
 * #TODO Dies sollte eigentlich passieren bevor der User nach dem Spot-Auth-Token gefragt wird!
 */
require_once './php/checkUserLogin.php';
checkUserLogin("Du musst eingeloggt sein");

require 'php/vendor/autoload.php';

$spoturl = $realSpotUrl . "scanning";

$session = new SpotifyWebAPI\Session($realSpotClientID, $realSpotClientSecret, $spoturl);

$api = new SpotifyWebAPI\SpotifyWebAPI();

if (isset($_GET['code'])) {
    
    $session->requestAccessToken($_GET['code']);
    $api->setAccessToken($session->getAccessToken());
    
    $options = array("limit" => "2");
    
    $lastPlayedSongs = $api->getMyRecentTracks($options);
    
    //var_dump($lastPlayedSongs);
    require_once './php/databaseCRUD.php';
    $timeLast = getLastTimeScanned();

    foreach ($lastPlayedSongs->items as $result) {
        $item = $result->track;
        $album = $item->album->name;
        $name = $item->name;
        $artist = $item->artists[0]->name;
        $spot_id = $item->id;
        $played_at = $result->played_at;
        if (strtotime($played_at) > $timeLast) {
            $artistObject = $api->getArtist($item->artists[0]->id);
            $song_id = insertIntoSong($name, $artist, $album, $spot_id, $artistObject->genres);
            insertIntoScanning($song_id);
        }
    }
    
    saveLastTimeScanned();

    header('Location: onthissitescanned?type=genre');
    die();
    
} else {
    $options = [
        'scope' => [
            'user-read-recently-played'
        ]
    ];
    
    header('Location: ' . $session->getAuthorizeUrl($options));
    die();
}

?>