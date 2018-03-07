
<div class="inner">
   <p>SpotEasy <?php echo getUserText() ?> </p>
</div>

<?php 

function getUserText() {
    if (isset($_SESSION['userID'])) {
        return " - logged in as: ".$_SESSION['userID'];
    }
}

?>