<?php 

function manCheck(){
	//Variabeln definieren und leere Werte einsetzen
	$yoursong = "";
	

	//Pr�fvariable
		
		//�berpr�fen ob das Formular ausgef�llt wurde
	if(isset($_POST["yoursong"]) && !empty($_POST["yoursong"])){
			
			//Auslesen der Daten und Anti-hacking und Pr�fvariable auf false setzen
	    require_once 'escapes.php';
	    $yoursong = htmlEscapses($_POST["yoursong"]);
	    require_once '.\php\databaseCRUD.php';
	    insertIntoSong($yoursong);
	    //header('Location: songList');
	    exit();
	} else {
	    $_SESSION['hinweisText'] = "Bitte geben Sie etwas ein.";
	    //header('Location: manually');
	}		


}



?>