<canvas id="erstesCanvas" >
</canvas>
<img id="papierkorb" src="./bilder/gusel.png" ondrop="drop(event)" ondragover="allowDrop(event)" />




<?php

require_once './php/checkUserLogin.php';
checkUserLogin();




require_once './php/databaseCRUD.php';
$result = getSongList($_SESSION['userID']);

$spotifyApproved = true;

if ($result->num_rows > 0) {
    $zaehler = "0";

    while ($row = mysqli_fetch_object($result)) {
        $song = "song";
        if ($zaehler%2== 0){
            $song = "song2";
        }
        $id = $row->song_id;
        $zaehler++;
        echo '<div class="songlist '.$song.'" data-id="'.$id.'">';
        echo "<p class='void'>";
        
        echo "<div class='column'>";
        echo $row->title;
        echo "</div>";
        echo "<div class='column'>";
        echo $row->time;
        echo "</div>";
        echo "<div class='column'>";
        sterne($row->rating, $id);
        loeschen($row->song_id);
        echo "</div>";
        echo "<div class='column'>";
        if (spotify($id, $row->spotify_id, $row->title)) {
            
        } else {
            $spotifyApproved = false;
        }
        echo "</div>";
        echo "</p>";
        echo '</div>';
    }
    
    if ($spotifyApproved) {
        ?>
        <form id="spotExport" action="addplaylist" method="POST">
        <h3><?php echo getLanguageOn(45); ?></h3>
        
        <p><?php echo getLanguageOn(46); ?></p>
        <label  for="loeschenJa"><p><?php echo getLanguageOn(48); ?></p>
          	<input type="radio" name="loeschen" id="loeschenJa" value="true" > 
        </label>
        
        <label for="loeschenNein"><p><?php echo getLanguageOn(47); ?></p>
  			<input type="radio" name="loeschen" id="loeschenNein" value="false" checked>
  		</label>
  			
  		<p>Berechtigungen</p>
  		<label  for="berechtigungenPublic"><p>Public</p>
  			<input type="radio" name="berechtigungen" id="berechtigungenPublic" value="public" > 
        </label>
        <label for="berechtigungenPrivate"><p>Private</p>
  			<input type="radio" name="berechtigungen" id="berechtigungenPrivate" value="private" checked>
  		</label>
  			
  			
  			
  			
  		 <input type="text" name="name" id="name" placeholder="playlistname" > 
  		  <input type="submit" value="<?php echo getLanguageOn(50); ?>">
        </form>
        
        
        <?php 
    }
    
} else {
   echo "<h2>".getLanguageOn(49)."</h2>"; 
}



function puffer() {
    return " ~ ";
}

function sterne($wertung, $id) {
    if ($wertung == "") {
        $wertung = 0;
    }
    for ($i=1;$i<6;$i++) {
        if ($i > $wertung) {
            echo '<img data-id="'.$id.'" data-nummer="'.$i.'"  class="stern" src="./bilder/stern.png" />';
        } else {
            echo '<img data-id="'.$id.'" data-nummer="'.$i.'" class="stern" src="./bilder/stern_full.png" />';
        }
    }
}

function spotify($idDB, $id_spot, $name) {
    if ($id_spot == "") {
        echo "Approve on Spotify";
        echo '<form action="resolve" method="POST">';
        echo '<input type="hidden" name="idDB" value="'.$idDB.'">';
        echo '<input type="hidden" name="name" value="'.$name.'">';
        echo '<input type="submit" value="resolve">';
        echo '</form>';
        return false;
    } else {
        echo '<img class="spotifyIcon" src="./bilder/spotify.png" />';
    }
    return true;
}

function loeschen($id) {
    echo '<img data-id="'.$id.'" class="loeschen" src="./bilder/loeschen.png" draggable="true" ondrag="changeSize(event)"  ondragend="dragEnded(event)" ondragstart="drag(event)" />';
}


?>


<script src="./js/songList.js" type="text/javascript"></script>
<script type="text/javascript">
    functionsToExecute.push(initializeSongList);
</script>