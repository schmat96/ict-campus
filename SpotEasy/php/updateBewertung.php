<?php
/**
 * Updatet die Bewertung für einen Song.
 * @var integer $id
 */
$id = 0;
if (isset($_POST["id"])) {
    $id = $_POST["id"];
}

$bewertung = 0;
if (isset($_POST["bewertung"])) {
    $bewertung = $_POST["bewertung"];
}

require_once 'databaseCRUD.php';
updateUserVote($bewertung, $_SESSION['userID'], $id);

?>