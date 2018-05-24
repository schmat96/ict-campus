<?php
/**
 * Checkt ob der User eingeloggt ist
 */
require_once './php/checkUserLogin.php';
checkUserLogin();

/**
 * Checkt ob der User einen Hinweis bekommen sollte (Beispielsweise "keine leeren Einträge")
 * @return string
 */
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

?>

<h1 class="cover-heading"><?php echo getLanguageOn(38); ?></h1>
<form name="" id="manForm" action="mancheck" method="post">
	<p class="lead">
		<!-- <p id="auth-token">	</p>	 -->
		<label for="mantext"><?php echo getLanguageOn(39); ?></label>
	</p>
	<p class="lead breit">
		<input id="mantext" type="text" class="breit"
			placeholder="<?php echo getLanguageOn(40); ?>" name="yoursong"
			oninput="mancheck()" onclick="mancheck()" aria-required="true">
	</p>
	<p class="lead">
		<input type="submit" id="submit" alt=""
			value="<?php echo strtolower(getLanguageOn(41)); ?>"
			class="btn btn-lg btn-secondary chooseButtons">
	</p>
	<p id="helpText"><?php echo phpHinweis(); ?></p>
</form>

<script src="./js/mancheck.js" type="text/javascript"></script>

<script type="text/javascript">
    	functionsToExecute.push(initializeMancheck);
	</script>

