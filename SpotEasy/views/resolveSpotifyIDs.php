<?php
require_once './php/checkUserLogin.php';
checkUserLogin();

require_once './php/vendor/autoload.php';

if (isset($_POST['name'])) {
    $_SESSION['resolving'] = $_POST['name'];
}

if (isset($_POST['idDB'])) {
    $_SESSION['id_track'] = $_POST['idDB'];
}

/**
 * Muss angepasst werden.
 * @var Ambiguous $session
 */
$session = new SpotifyWebAPI\Session('93c879989fe34da8a5d624dd56999a72', 
    '3feb65fe08ff46279d15c3ed25051577', 
    'http://www.ict-campus.net/43eKGM/schmidmath/resolve');

$api = new SpotifyWebAPI\SpotifyWebAPI();

if (isset($_GET['code'])) {
    
    $session->requestAccessToken($_GET['code']);
    
    $api->setAccessToken($session->getAccessToken());
    
    $options = array(
        "limit" => 10
    );
    
    $result = $api->search($_SESSION['resolving'], "track", $options);
    
    $array = $result->tracks->items;
    
    echo getLanguageOn(44);
    $zaehler = 0;
    foreach ($array as $item) {
        
        $song = "song";
        if ($zaehler % 2 == 0) {
            $song = "song2";
        }
        $zaehler ++;
        $trackName = $item->name;
        $artistName = $item->album->artists[0]->name;
        $albumName = $item->album->name;
        $spot_id = $item->id;
        
        echo '<div class="songlist ' . $song . ' ">';
        echo "<p class='void'>";
        echo "<div class='column'>";
        echo $trackName;
        echo "</div>";
        echo "<div class='column'>";
        echo $artistName;
        echo "</div>";
        echo "<div class='column'>";
        echo $albumName;
        echo "</div>";
        echo "<div class='column'>";
        
        confirmUpdate($trackName, $artistName, $albumName, $spot_id);
        echo "</div>";
        echo '</div>';
    }
    
    // header('Location: songlist');
} else {
    $options = [
        'scope' => [
            'user-read-currently-playing',
            'user-read-private'
        ]
    ];
    
    header('Location: ' . $session->getAuthorizeUrl($options));
    die();
}

function confirmUpdate($name, $artistName, $albumName, $spot_id)
{
    echo '<form action="updatespotid" method="POST">';
    echo '<input type="hidden" name="idDB" value="' . $_SESSION['id_track'] . '">';
    echo '<input type="hidden" name="name" value="' . $name . '">';
    echo '<input type="hidden" name="artist" value="' . $artistName . '">';
    echo '<input type="hidden" name="album" value="' . $albumName . '">';
    echo '<input type="hidden" name="spot_id" value="' . $spot_id . '">';
    echo '<input type="submit" value="Checkout">';
    echo '</form>';
}

?>