<?php
function databaseConnection() {
    $db = mysqli_connect("localhost", "root", "", "SpotEasy");
    $abfrage = "SET NAMES 'utf8'";
    if ($db->query($abfrage) === TRUE) {
        return $db;
    } else {
        return $db;
    }
    
    
}

?>