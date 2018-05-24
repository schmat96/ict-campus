<?php
/**
 * Der Builder für unsere Webseite. Setzt die Webseite zusammen
 * @param string $file Name
 * @param int $name Title Variable für language.
 */
function build($file, $name = "")
{
    ?>

<!doctype html>
<html lang="de">
<head>
<link rel="icon" href="./bilder/icon.png">

<meta charset="utf-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
        	<?php
    
    require_once './php/language.php';
    loadLanguage();
    require_once './php/titleAndIcon.php';
    setTitle($name);
    ?>
        	<script>
        		var pattName = "[a-zA-Z0-9]{5}";
   			  	var colorCorrect =  "rgba(0, 255, 0, .1)";
   			  	var colorWrong = "rgba(255, 50, 255, .1)";
   			  	var pattPW = "^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$";
   			  	var pattMail = "[a-zA-Z0-9_]+@[a-zA-Z0-9]+\\.[a-zA-Z0-9]{2}";
			  	var functionsToExecute = Array();
    		</script>

<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/cover.css" rel="stylesheet">
<link href="css/own.css" rel="stylesheet">
</head>

<body class="text-center" id="bodi">
	<div class="cover-container d-flex h-100 p-3 mx-auto flex-column">
		<header class="masthead mb-auto">
    			<?php
    if ($file == "") {} else {
        require_once 'header.php';
    }
    ?>
    		</header>


		<main role="main" class="inner cover">
    			
    			<?php require_once './views/'.$file; ?>
    		</main>

		<footer class="mastfoot mt-auto">
    			<?php require_once 'footer.php'; ?>
    		</footer>
	</div>

</body>

<!-- Bootstrap core JavaScript
        ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>window.jQuery || document.write('<script src="../../../../assets/js/vendor/jquery-min.js"><\/script>')</script>

<!-- 
Hier werden alle Funktionen aufegrufen, welche dem Array functionsToExecute hinzugefügt wurden.
Damit werden die Funktionen von Javascript erst nachdem die Seite geladen wurde aufgerufen. Ausserdem wurde zu diesem Zeitpunkt
JQuery schon geladen.
 -->
<script>
        for (index = 0; index < functionsToExecute.length; ++index) {
        	functionsToExecute[index]();
        }
        </script>

</body>
</html>


<?php
}
?>