<?php 
function build($file) {
    ?>

         <!doctype html>
        <html lang="de">
          <head>
          
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta name="description" content="">
            <meta name="author" content="">
            <link rel="icon" href="../../../../favicon.ico">
        	<?php 
        	
        	require_once './php/language.php';
        	loadLanguage();
        	?>
            <title>SpotEasyy - <?php getLanguageOn(1); ?></title>
            <link href="css/bootstrap.css" rel="stylesheet">
            <link href="css/cover.css" rel="stylesheet">
          </head>

    	  <body class="text-center">
    	  <div class="cover-container d-flex h-100 p-3 mx-auto flex-column">
    		<header class="masthead mb-auto">
    			<?php
    			if ($file=="") {
    			
    			} else {
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
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script>window.jQuery || document.write('<script src="../../../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
        <script src="../../../../assets/js/vendor/popper.min.js"></script>
        <script src="../../../../dist/js/bootstrap.min.js"></script>
        </body>
    </html>
    
    
<?php 
}
?>