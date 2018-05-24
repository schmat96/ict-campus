<?php
require_once './php/databaseCRUD.php';

if (isset($_GET['type'])) {
    if ($_GET['type'] != "") {
        $type = $_GET['type'];
    } else {
        $type = "genre";
    }
} else {
    $type = "genre";
}

if (isset($_POST['users'])) {
    if ($_POST['users'] != "") {
        // var_dump($_POST['users']);
        $result = getScanListGenre($_POST['users']);
        $result2 = getScanList($_POST['users']);
    } else {
        $result = getScanListGenre("");
        $result2 = getScanList("");
    }
} else {
    $result = getScanListGenre("");
    $result2 = getScanList("");
}

$zaehler = 1;
?>
<form id="switchOP" action="" method="GET">
	<label class="switch"> <input type="checkbox" id="sliderVal"
		<?php if ($type=='genre') { echo 'checked'; }?>> <span class="slider"></span>
	</label> <input type="hidden" id="sliderValGet" name="type" value="">
</form>

<div id="flip-container">
	<div class="flipper">
		<div id="front">
			<!-- front content -->
		
<?php
$users = array();

if ($result->num_rows > 0) {
    $gesamt = 0;
    $reihen = 0;
    while ($row = mysqli_fetch_object($result)) {
        $gesamt = $gesamt + $row->count;
        $user = $row->result2;
        
        echo '<div class="line" data-name="' . $user . '">';
        echo '<div class="nameScan"><p>';
        echo $row->result . ' (' . $row->count . ')';
        echo '</p></div>';
        echo '<canvas class="canvas" data-value="' . $row->count . '" data-zaehler="' . $zaehler . '"></canvas>';
        echo '</div>';
        $reihen ++;
        $zaehler ++;
        
        $found = array_search($user, $users);
        if ($found !== false) {} else {
            array_push($users, $user);
        }
    }
    
    echo '<p id="gesamt" data-gesamt="' . $gesamt . '" data-reihen="' . $reihen . '">Gesamt waren es: ' . $gesamt . ' und Reihen: ' . $reihen . ' </p>';
}

?>
</div>

		<div id="back" class="flipped">
			<!-- back content -->
		

<?php
if ($result->num_rows > 0) {
    $gesamt = 0;
    $reihen = 0;
    while ($row = mysqli_fetch_object($result2)) {
        $gesamt = $gesamt + $row->count;
        
        echo '<div class="nameScan"><p>';
        echo $row->result . ' (' . $row->count . ')';
        echo '</p></div>';
        echo '<canvas class="canvas" data-value="' . $row->count . '" data-zaehler="' . $zaehler . '"></canvas>';
        
        $reihen ++;
        $zaehler ++;
    }
    
    echo '<p id="gesamt" data-gesamt="' . $gesamt . '" data-reihen="' . $reihen . '">Gesamt waren es: ' . $gesamt . ' und Reihen: ' . $reihen . ' </p>';
}

?>


</div>
	</div>
</div>



<?php

function deprecated()
{
    echo '<form action="" method="post">';
    $users = getUsersFromScan();
    
    if ($users->num_rows > 0) {
        while ($row = mysqli_fetch_object($users)) {
            if (isset($_POST['users'])) {
                $key = array_search($row->user_id, $_POST['users']);
                if ($key != "") {
                    echo $row->user_id;
                    echo '<input type="checkbox" name="users[]" value="' . $row->user_id . '" checked>';
                } else {
                    echo $row->user_id;
                    echo '<input type="checkbox" name="users[]" value="' . $row->user_id . '">';
                }
            } else {
                echo $row->user_id;
                echo '<input type="checkbox" name="users[]" value="' . $row->user_id . '" checked>';
            }
        }
    }
    
    echo '<input type="submit" value="Submit">';
    echo '</form>';
}

?>



<script src="./js/scannedResults.js" type="text/javascript"></script>
<script type="text/javascript">
functionsToExecute.push(initScannedResults);
</script>

