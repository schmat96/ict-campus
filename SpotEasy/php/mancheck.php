<?php 

function manCheck(){
	/**
	 * Variabeln definieren und leere Werte einsetzen
	 */
	$yoursong = "";
	

	/**
	 * Überprüfen ob das Formular ausgefüllt wurde
	 */
	if(isset($_POST["yoursong"]) && !empty($_POST["yoursong"])){
			
	    /**
	     * Auslesen der Daten und Anti-hacking und Prüfvariable auf false setzen
	     */
	    require_once 'escapes.php';
	    $yoursong = htmlEscapses($_POST["yoursong"]);
	    require_once './php/databaseCRUD.php';
	    $song_id = insertIntoSong($yoursong);
	    insertIntoUserSong($_SESSION['userID'], $song_id);
	    
	    header('Location: songList');
	    exit();
	} else {
	    /**
	     * Anscheinend hat der User einen leeren Eintrag vorgenommen.
	     * @var Ambiguous $_SESSION Hier kann der Hinweis Text für den User gesetzt werden.
	     */
	    $_SESSION['hinweisText'] = "Bitte geben Sie etwas ein.";
	    header('Location: manually');
	}		


}



?>