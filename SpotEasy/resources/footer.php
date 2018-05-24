<?php

function getUserText()
{
    $notSetText = " - <a href=\"login\"> Login</a>";
    if (isset($_SESSION['userID'])) {
        if ($_SESSION['userID'] != "") {
            return " - logged in as: " . $_SESSION['userID'] . "<a href=\"logout\"> ~ Logout</a>";
        } else {
            return $notSetText;
        }
    }
    return $notSetText;
}

?>


<div class="inner">
	<p>SpotEasy - Johanna Koch & Mathias Schmid<?php echo getUserText()?> </p>
</div>

