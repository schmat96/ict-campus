<?php


if (empty($_POST)) {
    echo ("noch keine Rechnung");
} else {
    require_once '.\php\databaseCRUD.php';
    $var1 = $_POST["nummer1"];
    $var2 = $_POST["nummer2"];
    $var2 = $_POST["nummer3"];
    insertIntoLanguages($var1, $var2, $var2);
}
?>
		<form action="#" method="post">
  			CH<br>
  			<input type="text" name="nummer1" ><br>
  			EN<br>
  			<input type="text" name="nummer2" ><br>
			DE<br>
  			<input type="text" name="nummer3" ><br><br>
  			<input type="submit" value="Submit">
		</form>
		
		