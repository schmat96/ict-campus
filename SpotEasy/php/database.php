<?php
/**
 * Verbindet sich mit der Datenbank und setzt die Richtige Kollation.
 * @return $db Gibt die Datenbank zurück.
 */
function databaseConnection() {
    $db = mysqli_connect("srv08", "schmidmath", "Password2017", "schmidmath");
    $abfrage = "SET NAMES 'utf8'";
    if ($db->query($abfrage) === TRUE) {
        return $db;
    } else {
        return $db;
    }
}

?>