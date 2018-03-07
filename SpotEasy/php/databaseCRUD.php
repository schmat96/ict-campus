<?php

function insertIntoLanguages($val1, $val2, $val3) {
    require_once 'database.php';
    if (!isset($database)) {
        $database = databaseConnection();
    }
    if(!$database)
    {
        exit("Verbindungsfehler: ".mysqli_connect_error());
    } else {
        
        $abfrage = "INSERT INTO `tbl_languages` (`languages_ID`, `ch`, `en`, `de`) VALUES (NULL, ?, ?, ?)";
        
        if (!($stmt = $database->prepare($abfrage))) {
            echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
        
        if (!$stmt->bind_param("sss", $val1,$val2,$val3)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        
        $abfrage = "SELECT languages_ID as 'id' FROM `tbl_languages` WHERE ch = '".$val1."' and en = '".$val2."' and de = '".$val3."' ";

        $result = $database->query($abfrage);
        var_dump($result);
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_object($result)) {
                var_dump($row);
                echo $row->id;
            }
        } else {
            echo 'nichts gefunden';
        }
        
    }
}

function insertIntoUsers($val1, $val2) {
    require_once 'database.php';
    if (!isset($database)) {
        $database = databaseConnection();
    }
    if(!$database)
    {
        exit("Verbindungsfehler: ".mysqli_connect_error());
    } else {
               
        $abfrage = "INSERT INTO `tbl_user` (`email`, `password`, `password_salt`) VALUES (?, ?, ?)";
        
        if (!($stmt = $database->prepare($abfrage))) {
            echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
        
        require_once 'hash.php';
        $randomSalt = randomSalt(16);
        $hased = hashfunction($val2, $randomSalt);
        $_SESSION['userID'] = $val1;
        if (!$stmt->bind_param("sss", $val1,$hased, $randomSalt)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        
    }
    
}


?>