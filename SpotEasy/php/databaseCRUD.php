<?php
/**
 * #TODO Das Ganze als Klasse schreiben das ist ja unglaublich hier.
 */

/**
 * Ermöglicht das einfache einfügen von neuen Sprach einträgen. Wird nur für die Entwicklung der Webseite gebraucht!
 * @param String $val1 Schweizerdeutsche Eintrag
 * @param String $val2 Englischer Eintrag
 * @param String $val3 Deutscher Eintrag
 */

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
            echo "Prepare failed: (" . $database->errno . ") " . $database->error;
        }
        
        if (!$stmt->bind_param("sss", $val1,$val2,$val3)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        /**
         * Überprüft, welche ID der Eintrag hat und gibt ihn aus.
         */
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

/**
 * Fügt einen neuen User in die Datenbank. Dabei wird auch das Password Salz zufällig gebildet und gespeichert.
 * Je nach PHP-Version kann es vorkommen, dass ./php/hash.php nicht funktioniert (-->rand() ist veraltet!)
 * @param String $val1 Email des neuen Users
 * @param String $val2 Password des neuen Users.
 */
function insertIntoUsers($val1, $val2) {
    require_once 'database.php';

    if (!isset($database)) {
        $database = databaseConnection();
    }
    if(!$database)
    {
        exit("Verbindungsfehler: ".mysqli_connect_error());
    } else {
        /**
         * Bereitet die Abfrage vor
         */ 
        $abfrage = "INSERT INTO `tbl_user` (`email`, `password`, `password_salt`) VALUES (?, ?, ?)";
        if (!($stmt = $database->prepare($abfrage))) {
            echo "Prepare failed: (" . $database->errno . ") " . $database->error;
        }

        /**
         * Generiert zufällig das Salz.
         */
        require_once './php/hash.php';
        $randomSalt = randomSalt(16);
        /**
         * Hasht zusammen mit dem Salz das Passwort
         */
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

/**
 * Gibt die Songs einer Playlist zurück mithilfe der email (also dem Primary Key) des Users
 * @param String $email
 * @return array() mit den Songs, Zugriff mithilfe von $arr->[DB_Spalten_Namen]
 */
function getSongList($email) {
    $abfrage = "SELECT * FROM user_song left join tbl_songs on user_song.song_id = tbl_songs.id_song WHERE user_song.email_id = ?";
    $song_id = 0;
    require_once 'database.php';
    if (!isset($database)) {
        $database = databaseConnection();
    }
    if(!$database)
    {
        exit("Verbindungsfehler: ".mysqli_connect_error());
    } else {
        
        if ($stmt = $database->prepare($abfrage)) {
            
            $stmt->bind_param("s", $email);
            
            $stmt->execute();
            
            $result = $stmt->get_result();
            
            $stmt->fetch();
            
            $stmt->close();
            
            return $result;
        }
    }
}

/**
 * Gibt die ID aus der Datenbank zurück, mit welcher der Song mit dem $title gespeichert ist.
 * @param String $title Der Titel des Songs, nach dem gesucht wird.
 * @return number 0 falls er nicht gefunden wurde, ansonsten die ID aus der DB
 */
function getIDofSong($title) {
    $abfrage = "SELECT id_song as 'id' FROM `tbl_songs` WHERE title = ? ";
    $song_id = 0;
    require_once 'database.php';
    if (!isset($database)) {
        $database = databaseConnection();
    }
    if(!$database)
    {
        exit("Verbindungsfehler: ".mysqli_connect_error());
    } else {
        
        if ($stmt = $database->prepare($abfrage)) {
            
            $stmt->bind_param("s", $title);
            
            $stmt->execute();
            
            $stmt->bind_result($song_id);
            
            $stmt->fetch();
            
            $stmt->close();
        }
        return $song_id;
    }
    return 0;
}

/**
 * Fügt einen Song in die Datenbank ein.
 * @param string $title Titel des Songs.
 * @param string $artist Namen des Artists. can be NULL
 * @param string $album Namen des Albums. can be NULL
 * @param string $spotid2 Fremdschlüssel aus Spotify. can be NULL
 * @param array $genres Genres des Songs als array. can be NULL
 * @return number
 */
function insertIntoSong($title, $artist = "", $album = "", $spotid2 = "", $genres="") {
    echo "<h2>".$spotid2."</h2>";
    require_once 'database.php';
    $success = true;
    if (!isset($database)) {
        $database = databaseConnection();
    }
    if(!$database)
    {
        exit("Verbindungsfehler: ".mysqli_connect_error());
        $success = false;
    } else {
        /**
         * Checkt ob der Song schon bekannt ist
         * @var int $song_id
         */
        $song_id = getIDofSong($title);
        
        if ($song_id==0) {
            
            /**
             * Bereitet die Abfrage vor
             * @var string $abfrage
             */
            $abfrage = "INSERT INTO `tbl_songs` (`id_song`, `title`, `artist`, `album`, `spotify_id`) VALUES (NULL, ?, ?, ?, ?);";
            
            if (!($stmt = $database->prepare($abfrage))) {
                echo "Prepare failed: (" . $database->errno . ") " . $database->error;
                $success = false;
            }

            if (!$stmt->bind_param("ssss", $title, $artist, $album, $spotid2)) {
                echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
                $success = false;
            }
            
            if (!$stmt->execute()) {
                echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                $success = false;
            }
            $song_id = getIDofSong($title);
        }
        /**
         * Fügt die Genres zum Song hinzu falls das Array gesetzt wurde.
         * #TODO check ob $genres ein Array ist.
         */
        if ($genres!="") {
            addGenresToSong($genres, $song_id);
        }
        
    } 
    return $song_id; 
}

/**
 * Pro Genre wird ein einzelner SQL Befehl ausgeführt.
 * Existiert das Genre noch nicht, wird dieses zuerst noch erstellt.
 * @param array $genres die Genres als Array.
 * @param int $song_id die Song ID aus der DB
 */
function addGenresToSong($genres, $song_id) {
    $genreIDs = array();
    foreach ($genres as $genre) {
        array_push($genreIDs, addGenre($genre));
    }
    
    foreach ($genreIDs as $genreID) {
        addGenreSong($genreID, $song_id);
    }
}

/**
 * Fügt Genres zum Song hinzu.
 * @param int $genreID Genre ID aus der DB
 * @param int $song_id Song ID aus der DB
 */
function addGenreSong($genreID, $song_id) {
    require_once 'database.php';
    if (!isset($database)) {
        $database = databaseConnection();
    }
    if(!$database)
    {
        exit("Verbindungsfehler: ".mysqli_connect_error());
    } else {
        
        $abfrage = "INSERT INTO `genres_songs` (`genres_id`, `songs_id`) VALUES (?, ?)";
        
        if (!($stmt = $database->prepare($abfrage))) {
            echo "Prepare failed: (" . $database->errno . ") " . $database->error;
        }
        
        if (!$stmt->bind_param("si", $genreID,$song_id)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            if ($stmt->errno==1062) {
                echo "<br> Nothing to worry about.";
            }
        }
        
    }
    
}

/**
 * Fügt ein Genre in die Datenbank ein wenn es noch nicht existiert. 
 * Gibt die Genre ID aus der Datenbank zurück.
 * @param string $genre Name des Genre
 * @return number Genre ID
 */
function addGenre($genre) {
    require_once 'database.php';
    $genreID = 0;
    if (!isset($database)) {
        $database = databaseConnection();
    }
    if(!$database)
    {
        exit("Verbindungsfehler: ".mysqli_connect_error());
    } else {
        $genreID = getGenreID($genre);
        if ($genreID==0) {
            $abfrage = "INSERT INTO `tbl_genres` (`id_genre`, `genre`) VALUES (NULL, ?)";
            
            if (!($stmt = $database->prepare($abfrage))) {
                echo "Prepare failed: (" . $database->errno . ") " . $database->error;
            }
            
            if (!$stmt->bind_param("s", $genre)) {
                echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
            }
            
            if (!$stmt->execute()) {
                echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                if ($stmt->errno==1062) {
                    echo "<br> Nothing to worry about.";
                }
            } 
            $genreID = getGenreID($genre);
        }
    
        
    }
    return $genreID;
}

/**
 * Gibt das Genre ID aus der Db zurück
 * @param String $genre Name des Genre
 * @return number Genre ID aus der DB
 */
function getGenreID($genre) {
    $abfrage = "SELECT id_genre FROM tbl_genres WHERE genre = ?";
    $genreID = 0;
    require_once 'database.php';
    if (!isset($database)) {
        $database = databaseConnection();
    }
    if(!$database)
    {
        exit("Verbindungsfehler: ".mysqli_connect_error());
    } else {
        
        if ($stmt = $database->prepare($abfrage)) {
            
            $stmt->bind_param("s", $genre);
            
            $stmt->execute();
            
            $stmt->bind_result($genreID);
            
            $stmt->fetch();
            
            $stmt->close();
        }
    }
    return $genreID;
}

/**
 * Fügt einen Song zu der Playlist des Users.
 * @param string $email Email des Users
 * @param int $song ID des Songs aus der DB
 * 
 * #TODO Check ob Email überhaupt existiert.
 */
function insertIntoUserSong($email, $song) {
    require_once 'database.php';
    if (!isset($database)) {
        $database = databaseConnection();
    }
    if(!$database)
    {
        exit("Verbindungsfehler: ".mysqli_connect_error());
    } else {
        
        $abfrage = "INSERT INTO `user_song` (`email_id`, `song_id`, `time`, `timeLastUpdate`, `rating`, `count`) VALUES (?, ?, now(), NULL, NULL, 1)";
        
        if (!($stmt = $database->prepare($abfrage))) {
            echo "Prepare failed: (" . $database->errno . ") " . $database->error;
        }
        
        
        if (!$stmt->bind_param("si", $email,$song)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            if ($stmt->errno==1062) {
                echo "<br> Nothing to worry about. Counting Up you little Dude. Okay dies muss noch implementiert werden.";
                countUp($email, $song);
            }
        }
        
    }
    
}

/**
 * Fügt einen Song zur globalen Liste aller Scans hinzu
 * @param int $song Song ID aus der DB
 */
function insertIntoScanning($song) {
    require_once 'database.php';
    if (!isset($database)) {
        $database = databaseConnection();
    }
    if(!$database)
    {
        exit("Verbindungsfehler: ".mysqli_connect_error());
    } else {
        
        $abfrage = "INSERT INTO `tbl_scanning` (`song_id`,`user_id`, `count`) VALUES (?, ?, 1)";
        
        if (!($stmt = $database->prepare($abfrage))) {
            echo "Prepare failed: (" . $database->errno . ") " . $database->error;
        }
        
        $userID = $_SESSION['userID'];
        
        if (!$stmt->bind_param("is", $song, $userID)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            if ($stmt->errno==1062) {
                echo "<br> Nothing to worry about. Counting Up you little Dude.";
                countUpScanning($song, $userID);
            }
        }
        
    }
    
}

/**
 * Zählt die Spalte count hoch. Wird aufgerufen, falls der Song schon in der Playlist existiert hat.
 * @param String $email Email des Users.
 * @param int $song Song ID aus der DB.
 */
function countUp($email, $song) {
    require_once 'database.php';
    if (!isset($database)) {
        $database = databaseConnection();
    }
    if(!$database)
    {
        exit("Verbindungsfehler: ".mysqli_connect_error());
    } else {
        $abfrage = "UPDATE user_song SET count = ? WHERE email_id = ? AND song_id = ?";
        
        if (!($stmt = $database->prepare($abfrage))) {
            echo "Prepare failed: (" . $database->errno . ") " . $database->error;
        }
        
        $rating = getCount($email, $song);
        $rating++;
        if (!$stmt->bind_param("isi", $rating,$email,$song)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
    }
}

/**
 * Zählt den Zähler aus tbl_scanning hoch. Wird aufgerufen falls der Song in der Tabelle schon existiert hat.
 * @param int $song
 * @param string $email
 */
function countUpScanning($song, $email) {
    require_once 'database.php';
    if (!isset($database)) {
        $database = databaseConnection();
    }
    if(!$database)
    {
        exit("Verbindungsfehler: ".mysqli_connect_error());
    } else {
        $abfrage = "UPDATE tbl_scanning SET count = ? WHERE song_id = ? and user_id = ?";
        
        if (!($stmt = $database->prepare($abfrage))) {
            echo "Prepare failed: (" . $database->errno . ") " . $database->error;
        }
        
        $rating = getCountScanning($song, $email);
        $rating++;
        if (!$stmt->bind_param("iis", $rating,$song, $email)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
    }
}

/**
 * Gibt den Zähler aus user_song des Songs zusammen mit der Email zurück.
 * @param string $email Email des Users
 * @param int $song ID des Songs
 * @return number Gibt den Zähler zurück.
 */
function getCount($email, $song) {
    $abfrage = "SELECT count FROM user_song WHERE email_id = ? AND song_id = ?";
    $count = 0;
    require_once 'database.php';
    if (!isset($database)) {
        $database = databaseConnection();
    }
    if(!$database)
    {
        exit("Verbindungsfehler: ".mysqli_connect_error());
    } else {
        
        if ($stmt = $database->prepare($abfrage)) {
            
            $stmt->bind_param("si", $email, $song);
            
            $stmt->execute();
            
            $stmt->bind_result($count);
            
            $stmt->fetch();
            
            $stmt->close();
            
            return $count;
        }
    }
}

/**
 * Gibt den Zähler aus tbl_scanning des Songs zusammen mit der Email zurück.
 * @param string $email Email des Users
 * @param int $song ID des Songs
 * @return number Gibt den Zähler zurück.
 */
function getCountScanning($song, $email) {
    $abfrage = "SELECT count FROM tbl_scanning WHERE song_id = ? AND user_id = ?";
    $count = 0;
    require_once 'database.php';
    if (!isset($database)) {
        $database = databaseConnection();
    }
    if(!$database)
    {
        exit("Verbindungsfehler: ".mysqli_connect_error());
    } else {
        
        if ($stmt = $database->prepare($abfrage)) {
            
            $stmt->bind_param("is", $song, $email);
            
            $stmt->execute();
            
            $stmt->bind_result($count);
            
            $stmt->fetch();
            
            $stmt->close();
            
            return $count;
        }
    }
}

/**
 * Updated die Bewertung für einen Song des Users.
 * @param int $rating Neues rating für den Song [0-4]
 * @param string $email_id Email des Users
 * @param int $song_id Song ID aus der DB
 */
function updateUserVote($rating,$email_id,$song_id){
    require_once 'database.php';
    if (!isset($database)) {
        $database = databaseConnection();
    }
    if(!$database)
    {
        exit("Verbindungsfehler: ".mysqli_connect_error());
    } else {
        $abfrage = "UPDATE user_song SET rating = ? WHERE email_id = ? AND song_id = ?";
        
        if (!($stmt = $database->prepare($abfrage))) {
            echo "Prepare failed: (" . $database->errno . ") " . $database->error;
        }
        
        
        if (!$stmt->bind_param("isi", $rating,$email_id,$song_id)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
    }
    
}

/**
 * Löscht einen Song aus einer Playlist des Users.
 * @param string $email_id Email des Users
 * @param int $song_id Song ID aus der DB
 */
function deleteUserSong($email_id,$song_id){
    require_once 'database.php';
    if (!isset($database)) {
        $database = databaseConnection();
    }
    if(!$database)
    {
        exit("Verbindungsfehler: ".mysqli_connect_error());
    } else {
        $abfrage = "DELETE FROM `user_song` WHERE `user_song`.`email_id` = ? AND `user_song`.`song_id` = ?";
        
        if (!($stmt = $database->prepare($abfrage))) {
            echo "Prepare failed: (" . $database->errno . ") " . $database->error;
        }
        
        
        if (!$stmt->bind_param("si",$email_id,$song_id)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
    }
    
}

/**
 * Updatet die Parameter eines Songs in der DB.
 * @param int $id ID des Songs
 * @param string $name Neuer Name des Songs
 * @param string $album Neuer Albumname des Songs
 * @param string $artist Neuer Artistname des Songs
 * @param string $spot_id Neue Spotify ID
 */
function updateSpotifyID($id, $name, $album, $artist, $spot_id) {
    require_once 'database.php';
    if (!isset($database)) {
        $database = databaseConnection();
    }
    if(!$database)
    {
        exit("Verbindungsfehler: ".mysqli_connect_error());
    } else {
        $abfrage = "UPDATE tbl_songs SET title = ?, artist = ?, album = ?, spotify_id = ? WHERE tbl_songs.id_song = ?";
        
        if (!($stmt = $database->prepare($abfrage))) {
            echo "Prepare failed: (" . $database->errno . ") " . $database->error;
        }
        
        echo "  ===> ".$spot_id;
        
        if (!$stmt->bind_param("ssssi", $name, $artist, $album, $spot_id, $id)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
    }
}

/**
 * Speichert die Zeit des Users, wenn er das letzte mal auf den Scan Button gedrückt hat.
 */
function saveLastTimeScanned() {
    require_once 'database.php';
    if (!isset($database)) {
        $database = databaseConnection();
    }
    if(!$database)
    {
        exit("Verbindungsfehler: ".mysqli_connect_error());
    } else {
        $abfrage = "UPDATE tbl_user SET lastScanned = ? WHERE email = ?";
        
        if (!($stmt = $database->prepare($abfrage))) {
            echo "Prepare failed: (" . $database->errno . ") " . $database->error;
        }
      
        $time = time();
        
        if (!$stmt->bind_param("is", $time, $_SESSION['userID'])) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
    }
}

/**
 * Gibt die Zeit in MS zurück, die der User das letzte mal gescannt hat.
 * @return number int als MS von Linux dingsbums.
 */
function getLastTimeScanned() {
    $abfrage = "SELECT lastScanned FROM tbl_user WHERE email = ?";
    $count = 0;
    require_once 'database.php';
    if (!isset($database)) {
        $database = databaseConnection();
    }
    if(!$database)
    {
        exit("Verbindungsfehler: ".mysqli_connect_error());
    } else {
        
        if ($stmt = $database->prepare($abfrage)) {
            
            $stmt->bind_param("s", $_SESSION['userID']);
            
            $stmt->execute();
            
            $stmt->bind_result($count);
            
            $stmt->fetch();
            
            $stmt->close();
            
            return $count;
        } else {
            return -1;
        }
    }
}

/**
 * Gibt das Array Zurück aus tbl_scanning gruppiert nach dem Artisten.
 * @param string $array
 * @return array Zugriff mithilfe von $arr->artist
 */
function getScanList($array = "") {
    if (is_array($array)) {
        $abfrage = "SELECT SUM(tbl_scanning.count) as count, artist as result, user_id as result2 FROM tbl_scanning left join tbl_songs on tbl_songs.id_song = tbl_scanning.song_id where user_id IN (".implode(',',$array).") group by artist order by count desc";
    } else {
        $abfrage = "SELECT SUM(tbl_scanning.count) as count, artist as result, user_id as result2 FROM tbl_scanning left join tbl_songs on tbl_songs.id_song = tbl_scanning.song_id group by artist order by count desc";
    }
        
    
    require_once 'database.php';
    if (!isset($database)) {
        $database = databaseConnection();
    }
    if(!$database)
    {
        exit("Verbindungsfehler: ".mysqli_connect_error());
    } else {
        
        if ($stmt = $database->prepare($abfrage)) {
            
            $stmt->execute();
            
            $result = $stmt->get_result();
            
            $stmt->fetch();
            
            $stmt->close();
            
            return $result;
        }
    }
}


/**
 * Gibt das Array Zurück aus tbl_scanning gruppiert nach dem Genre.
 * @param string $array
 * @return array Zugriff mithilfe von $arr->artist
 */
function getScanListGenre($array = "") {
    if (is_array($array)) {
        $abfrage = "select tbl_genres.genre as result, hue.count, userid as result2 from tbl_genres join (SELECT SUM(tbl_scanning.count) as count, top.genres_id as id, user_id as userid FROM tbl_scanning left join (select id_song, genres_songs.genres_id from tbl_songs right join genres_songs on songs_id = tbl_songs.id_song) as top on top.id_song = tbl_scanning.song_id where user_id IN (".implode(',',$array).") group by top.genres_id order by count desc) as hue on hue.id = tbl_genres.id_genre order by count desc";
    } else {
        $abfrage = "select tbl_genres.genre as result, hue.count, userid as result2 from tbl_genres join (SELECT SUM(tbl_scanning.count) as count, top.genres_id as id, user_id as userid FROM tbl_scanning left join (select id_song, genres_songs.genres_id from tbl_songs right join genres_songs on songs_id = tbl_songs.id_song) as top on top.id_song = tbl_scanning.song_id group by top.genres_id order by count desc) as hue on hue.id = tbl_genres.id_genre order by count desc";
    }
        
    
    require_once 'database.php';
    if (!isset($database)) {
        $database = databaseConnection();
    }
    if(!$database)
    {
        exit("Verbindungsfehler: ".mysqli_connect_error());
    } else {
        
        if ($stmt = $database->prepare($abfrage)) {
            
            $stmt->execute();
            
            $result = $stmt->get_result();
            
            $stmt->fetch();
            
            $stmt->close();
            
            return $result;
        }
    }
}

/**
 * Gibt alle User zurück, welche den Scan Button einmal erfolgreich gedrückt haben.
 * @return array der User
 */
function getUsersFromScan() {

    $abfrage = "SELECT user_id FROM `tbl_scanning` group by user_id";

    require_once 'database.php';
    if (!isset($database)) {
        $database = databaseConnection();
    }
    if(!$database)
    {
        exit("Verbindungsfehler: ".mysqli_connect_error());
    } else {
        
        if ($stmt = $database->prepare($abfrage)) {
            
            $stmt->execute();
            
            $result = $stmt->get_result();
            
            $stmt->fetch();
            
            $stmt->close();
            
            return $result;
        }
    }
}



?>