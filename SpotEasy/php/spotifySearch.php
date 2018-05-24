<?php

/**
 * Sucht auf Spotify nach einem Song der dem Namen ............
 * @deprecated
 * @var Ambiguous $spoturl
 */
$spoturl = $realSpotUrl."scan";

$session = new SpotifyWebAPI\Session(
    $realSpotClientID,
    $realSpotClientSecret,
    $spoturl
    );

$api = new SpotifyWebAPI\SpotifyWebAPI();

if (isset($_GET['code'])) {
    
    $session->requestAccessToken($_GET['code']);
    
    $api->setAccessToken($session->getAccessToken());
    
    $options = array("limit" => 5);
    
    $result = $api->search("Lose you", "track", $options);
    
    $array = $result->tracks->items;
    
    foreach ($array as $item) {

        echo "Track: ";
        echo $item->name;
        echo " - Artist:";
        echo $item->album->artists[0]->name;
        echo " - Album: ";
        echo $item->album->name;
        echo " - ";
        echo "<br>";
    }
    

    //header('Location: songlist');
    
    
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