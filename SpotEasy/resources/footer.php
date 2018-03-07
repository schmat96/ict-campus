
<div class="inner">

   <p>SpotEasy - Johanna Koch & Mathias Schmid & Dini Mutz4rpokeetter</p>

</div>

<?php 

function getUserText() {
    if (isset($_SESSION['userID'])) {
        return " - logged in as: ".$_SESSION['userID'];
    }
}

?>