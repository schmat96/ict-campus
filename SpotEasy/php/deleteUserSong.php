<?php
/**
 * Löscht einen Song mit der $id aus der DB. Die User ID bekommt er aus der Session.
 * @var integer $id wird per $_POST['id'] übergeben. 
 */
$id = 0;
if (isset($_POST["id"])) {
    $id = $_POST["id"];
}

require_once 'databaseCRUD.php';
deleteUserSong($_SESSION['userID'] ,$id);

?>