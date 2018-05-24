<?php 

/**
 * Checkt ob in der $_SESSION[] die benötigten Werte schon einmal gespeichert wurden. Dies ermöglicht die eine nicht vollständige
 * Registrierung abzubrechen und später weiterzufahren.
 * @return unknown|string
 */
function email() {
    if (isset($_SESSION['email'])) {
        if ($_SESSION['email']!="") {
            $returnText = $_SESSION['email'];
            
            return $returnText; 
        }
    }
    return "";
}


function password1() {
    if (isset($_SESSION['password1'])) {
        if ($_SESSION['password1']!="") {
            $returnText = $_SESSION['password1'];
           
            return $returnText; 
        }
    } 
    return "";
}

function password2() {
    if (isset($_SESSION['password2'])) {
        if ($_SESSION['password2']!="") {
            $returnText = $_SESSION['password2'];
            
            return $returnText; 
        }
    }
    return "";
}

function phpHinweis() {
    if (isset($_SESSION['hinweisText'])) {
        if ($_SESSION['hinweisText']!="") {
            $returnText = $_SESSION['hinweisText'];
            $_SESSION['hinweisText'] = "";
            return $returnText; 
        }
    } 
    return "";
}

?>

         

 
 <h1 class="cover-heading"><?php echo getLanguageOn(11); ?></h1>
<form name="" id="regForm" action="registerCheck" method="post">		
	<label for="regEmail">Email<span id="emailFormHinweis"></span></label>
	<input id="regEmail" type="text" placeholder="E-Mail" oninput="checkRegister()" onclick="checkRegister()" name="email" aria-required="true" value="<?php echo email(); ?>">		
	<label for="regPasswort1"><?php echo getLanguageOn(12); ?><span id="passwort1FormHinweis"> </span></label>
	<input id="regPasswort1" type="password" placeholder="<?php echo getLanguageOn(12); ?>" oninput="checkRegister()" onclick="checkRegister()" name="password1" value="<?php echo password1(); ?>">		
	<label for="regPasswort2"><?php echo getLanguageOn(13); ?><span id="passwort2FormHinweis"> </span></label>
	<input id="regPasswort2" type="password" placeholder="<?php echo getLanguageOn(13); ?>" oninput="checkRegister()" onclick="checkRegister()" name="password2" value="<?php echo password2(); ?>">	  
	<input type="submit" id="submit" alt="" value="<?php echo getLanguageOn(37); ?>" >
	<p id="helpText"><?php echo phpHinweis(); ?></p>	
</form>

<h2><a href="login"> <?php echo getLanguageOn(36); ?></a></h2>

	<script src="./js/register.js" type="text/javascript"></script>
    <script type="text/javascript">
    	functionsToExecute.push(initializeRegister);
	</script>




   