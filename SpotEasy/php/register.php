<?php 
/**
 * Überprüft das Formular für die Registrierung. Falls alles den Vorgaben entspricht wird der neue User
 * in die DB eingefügt und eingeloggt.
 */
function registerCheck() {

      //Variabeln definieren und leere Werte einsetzen

      $email = $password1 = $password2 = "";
      
      $hinweisText = array(
          "mail" => "Deine E-Mail entspricht nicht den Vorgaben!",
          "pw1" => "Deine Passwort entspricht nicht den Vorgaben!",
          "pw2" => "Dein zweites Passwort entspricht nicht dem ersten!"
      );
      
      $hinweisTextReturn = array();
      
      
      //Überprüfen ob das Formular ausgefüllt wurde --> Register ist value von submit-button
      if(isset($_POST["email"]) && isset($_POST["password1"]) && isset($_POST["password2"])){
     	
     	//Auslesen der Daten und testen
     	
          require_once 'escapes.php';
          
          $email = htmlEscapses($_POST["email"]);
          $password1 = htmlEscapses($_POST["password1"]);
          $password2 = htmlEscapses($_POST["password2"]);

     	
     	//Prüfvariabel
     	$emailinv = false;
     	$passwinv = false;
     	
     	//Email überprüfen
     	if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
     	    array_push($hinweisTextReturn, $hinweisText['mail']);
     		$emailinv = true;
     	}
     	
     	//Passwort überprüfen und ob beide pw gleich sind
     	if (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%&*-]).{8,}$/", $password1)){
     	    array_push($hinweisTextReturn, $hinweisText['pw1']);
     		$passwinv = true;
     	}
     	elseif ($password1 != $password2){
     	    array_push($hinweisTextReturn, $hinweisText['pw2']);
     		$passwinv = true;
     	}
     	
     	//Check ob alles richtig ausgefüllt war
     	if (!$emailinv && !$passwinv){
     		require_once './php/databaseCRUD.php';
     		echo "komisch";
     		$id = insertIntoUsers($email, $password1);
     		header('Location: login');
     	} else {
     	    
     	    $_SESSION['email'] = $email;
     	    $_SESSION['password1'] = $password1;
     	    $_SESSION['password2'] = $password2;
     	    $text = "";
     	    var_dump($hinweisTextReturn);
     	    foreach ($hinweisTextReturn as $arr) {
     	        $text = $text."<br>".$arr;
     	    }
     	    $_SESSION['hinweisText'] = $text;
     	    echo $text;
     	   
     	    header('Location: register');
     	    exit();
     	}
     	
     }else{
     	//Warnung
     	echo'<?php getLanguageOn(1); ?>';
     }

}
?>