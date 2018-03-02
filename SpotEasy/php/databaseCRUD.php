<?php

function insertIntoLanguages($val1, $val2, $val3) {
    require_once 'database.php';
    $database = databaseConnection();
    if(!$database)
    {
        exit("Verbindungsfehler: ".mysqli_connect_error());
    } else {
        $abfrage = "INSERT INTO `tbl_languages` (`languages_ID`, `ch`, `en`, `de`) VALUES (NULL, '".$val1."', '".$val2."', '".$val2."')";
        if ($database->query($abfrage) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $abfrage . "<br>" . $database->error;
        }
      
    }
    
}


?>