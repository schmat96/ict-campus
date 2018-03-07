<?php


if (empty($_POST)) {
    echo ("Noch keine Eingaben.");
} else {
    require_once '.\php\databaseCRUD.php';
    $var1 = $_POST["nummer1"];
    $var2 = $_POST["nummer2"];
    $var3 = $_POST["nummer3"];
    echo ("<h3>Deine letzte Eingabe: CH:".$var1." EN: ".$var2." DE: ".$var3." with ID: ");
    $id = insertIntoLanguages($var1, $var2, $var3);
    echo $id."</h3>";
}
?>
		<form action="#" method="post">
  			CH<br>
  			<input type="text" name="nummer1" ><br>
  			EN<br>
  			<input type="text" name="nummer2" ><br>
			DE<br>
  			<input type="text" name="nummer3" ><br><br>
  			<input type="submit" value="<?php echo getLanguageOn(6); ?>">
		</form>
		
		