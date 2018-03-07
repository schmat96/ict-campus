<?php
function loginCheck(){
	//Variabeln definieren und leere Werte einsetzen
	$email = $password = "";
	
	//Funktion um gewisse Sonderzeichen etc von Usereingaben abzutrennen (Anti-Hacker)
	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	//�berpr�fen ob das Formular ausgef�llt wurde
	if(isset($_POST["email"]) && isset($_POST["password"])){
		
		//Auslesen der Daten und Anti-Hacking
		$email = test_input($_POST["email"]);
		$password = test_input($_POST["password"]);
		
		//Pr�fvariabel
		$emailinv = false;
		$passwinv = false;
		
		//Verbinden mit der Userdatenbank
		require_once 'database.php';
		if (!isset($database)) {
			$database = databaseConnection();
		}
		if(!$database)
		{
			exit("Verbindungsfehler: ".mysqli_connect_error());
		} else {
			//Email �berpr�fen
			$sqlemail = "SELECT * FROM tbl_user where email = $email";
			$sqlemailres = $database->query($sqlemail);
		
			if ($sqlmailres->num_rows > 0){
				while ($row = msqli_fetch_object($result)){
					$dbpw = $row->password;
					$dbsalt = $row->password_salt;
				}
				//Passwort �berpr�fen wenn Email existiert
				$hashpw = hashfunction($password,$dbsalt);
				if ($hashpw != $dbpw){
					$passwinv = true;
				}	
			} else {
				$emailinv = true;				
			}
		}
		
		//Check ob alles richtig ausgef�llt war
		if (!$emailinv && !$passwinv){
			//PLS Usf�lle
		}
	}
}

?>