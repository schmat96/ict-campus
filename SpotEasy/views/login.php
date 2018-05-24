<?php

/**
 * Checkt ob in der $_SESSION[] die benötigten Werte schon einmal gespeichert wurden. Dies ermöglicht die eine nicht vollständige
 * Anmeldung abzubrechen und später weiterzufahren.
 * @return unknown|string
 */
function email()
{
    if (isset($_SESSION['email'])) {
        if ($_SESSION['email'] != "") {
            $returnText = $_SESSION['email'];
            return $returnText;
        }
    }
    return "";
}

function password1()
{
    if (isset($_SESSION['password1'])) {
        if ($_SESSION['password1'] != "") {
            $returnText = $_SESSION['password1'];
            return $returnText;
        }
    }
    return "";
}

function phpHinweis()
{
    if (isset($_SESSION['hinweisText'])) {
        if ($_SESSION['hinweisText'] != "") {
            $returnText = $_SESSION['hinweisText'];
            $_SESSION['hinweisText'] = "";
            return $returnText;
        }
    }
    return "";
}

function loginhinweis()
{
    if (isset($_SESSION['hinweis'])) {
        if ($_SESSION['hinweis'] != "") {
            $loginHinweisText = $_SESSION['hinweis'];
            $_SESSION['hinweis'] = "";
            echo $loginHinweisText;
        }
    }
    return "";
}
?>


<h1 class="cover-heading"><?php echo getLanguageOn(9); ?></h1>
<h3><?php loginhinweis();?></h3>
<form name="" id="regForm" action="loginCheck" method="post">
	<label for="regEmail">Email<span id="emailFormHinweis"></span></label>
	<input id="regEmail" type="text" placeholder="E-Mail"
		oninput="checkLogin()" onclick="checkLogin()" name="email"
		aria-required="true" value="<?php echo email(); ?>"> <label
		for="regPasswort1"><?php echo getLanguageOn(12); ?><span
		id="passwort1FormHinweis"> </span></label> <input id="regPasswort1"
		type="password" placeholder="<?php echo getLanguageOn(12); ?>"
		oninput="checkLogin()" onclick="checkLogin()" name="password"
		value="<?php echo password1(); ?>"> <input type="submit" id="submit"
		alt="" value="<?php echo strtolower(getLanguageOn(9)); ?>">
	<p id="helpText"><?php echo phpHinweis(); ?></p>

</form>
<h2>
	<a href="register"> <?php echo getLanguageOn(11); ?></a>
</h2>


<script src="./js/login.js" type="text/javascript"></script>
<script type="text/javascript">
    	functionsToExecute.push(initializeLogin);
	</script>

