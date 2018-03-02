<?php
function databaseConnection() {
    return mysqli_connect("localhost", "root", "", "SpotEasy");
}

?>