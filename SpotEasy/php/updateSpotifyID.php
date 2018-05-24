<?php
/**
 * Updatet die Spotify ID, den Namen, das Album und den Artisten für einen Track. 
 * @var integer $id
 */
$id = 0;
if (isset($_POST["idDB"])) {
    $id = $_POST["idDB"];
}

$name = "";
if (isset($_POST["name"])) {
    $name = $_POST["name"];
}

$album = "";
if (isset($_POST["album"])) {
    $album = $_POST["album"];
}

$artist = "";
if (isset($_POST["artist"])) {
    $artist = $_POST["artist"];
}

$spot_id = "";
if (isset($_POST["spot_id"])) {
    $spot_id = $_POST["spot_id"];
}

require_once 'databaseCRUD.php';
updateSpotifyID($id, $name, $album, $artist, $spot_id);
header('Location: songlist');

?>