<?php

/**
 * Checkt ob das Login korrekt ist. 
 * Falls alles korrekt ist, wird die $_SESSION['userID'] gesetzt.
 */
function loginCheck(){
	/**
	 * Variabeln definieren und leere Werte einsetzen
	 */
	$email = $password = "";
    /**
     * Überprüfen ob das Formular ausgefüllt wurde
     */
	if(isset($_POST["email"]) && isset($_POST["password"])){
		
		/**
		 * Auslesen der Daten und Anti-Hacking
		 */
		require_once 'escapes.php';
	    
	    $email = htmlEscapses($_POST["email"]);
	    $password = htmlEscapses($_POST["password"]);
		
		/**
		 * Prüfvariabel
		 */
		$emailinv = false;
		$passwinv = false;
		$salt = "";
		$emailDB = "";
		
		/**
		 * Verbinden mit der Userdatenbank
		 * #TODO auf php/databaseCRUD.php auslagern!
		 */
		require_once 'database.php';
		if (!isset($database)) {
			$database = databaseConnection();
		}
		if(!$database)
		{
			exit("Verbindungsfehler: ".mysqli_connect_error());
		} else {
			
			/**
			 * Email überprüfen
			 * @var Ambiguous $abfrage
			 * #TODO SQL Incejtion nicht gewährleistet.............
			 */
		    $abfrage = 'SELECT * FROM `tbl_user` where email = \''.$email.'\'';
			$result = $database->query($abfrage);
		    echo "<br>";
			var_dump($result);
			if ($result->num_rows > 0) {
			    while ($row = mysqli_fetch_object($result)) {
			        var_dump($row);
			        $emailDB = $row->email;
			        $salt = $row->password_salt;
			        $hashedDB = $row->password;
			        if ($email == $emailDB) {
			            $emailinv = true;
			            require_once 'hash.php';
			            $hashed = hashfunction($password, $salt);
			            if ($hashed == $hashedDB) {
			                $passwinv = true;
			            }
			        } else {
			            
			        }
			    }
			} else {
			   echo "<br>test";
			}
		}
		
		/**
		 * Check ob alles richtig ausgefüllt war
		 */
		if ($emailinv){
		    if ($passwinv) {
		        $_SESSION['userID'] = $email;
		        header('Location: home');
		        exit();
		    } else {
		        $_SESSION['email'] = $email;
		        $_SESSION['password1'] = $password;
		        $text = "Passwort stimmt nicht";
		        echo $text;
		        $_SESSION['hinweisText'] = $text;
		        header('Location: login');
		        exit();
		    }
		   
		} else {
		    $_SESSION['email'] = $email;
		    $_SESSION['password1'] = $password;
		    $text = "E-Mail und Passwort stimmen nicht";
		    echo $text;
		    $_SESSION['hinweisText'] = $text;
		    
		    header('Location: login');
		    exit();
		}
	}
}

?>