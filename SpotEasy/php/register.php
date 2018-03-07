<?php 
function registerCheck() {

      //Variabeln definieren und leere Werte einsetzen

      $email = $password1 = $password2 = "";
      
      $hinweisText = array(
          "mail" => "Deine E-Mail entspricht nicht den Vorgaben!",
          "pw1" => "Deine Passwort entspricht nicht den Vorgaben!",
          "pw2" => "Dein zweites Passwort entspricht nicht dem ersten!"
      );
      
      $hinweisTextReturn = array();
      
      //Funktion um gewisse Sonderzeichen etc von Usereingaben abzutrennen (Anti-Hacker)
      function test_input($data){
      	$data = trim($data);
      	$data = stripslashes($data);
      	$data = htmlspecialchars($data);
      	return $data;
      }
      
      //Überprüfen ob das Formular ausgefüllt wurde --> Register ist value von submit-button
      if(isset($_POST["email"]) && isset($_POST["password1"]) && isset($_POST["password2"])){
     	
     	//Auslesen der Daten und testen
     	$email = test_input($_POST["email"]);
     	$password1 = test_input($_POST["password1"]);
     	$password2 = test_input($_POST["password2"]);

     	
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
     		echo 'alles ok';
     		require_once '.\php\databaseCRUD.php';
     		$id = insertIntoUsers($email, $password1);
     		header('Location: http://localhost/SpotEasy2/ict-campus/SpotEasy/about');
     	} else {
     	    echo "<br>ich war hier";
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
     	   
     	    header('Location: http://localhost/SpotEasy2/ict-campus/SpotEasy/register');
     	    exit();
     	}
     	
     }else{
     	//Warnung
     	echo'<?php getLanguageOn(1); ?>';
     }

}
?>