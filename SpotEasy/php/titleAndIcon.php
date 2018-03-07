<?php
function setTitle ($val = "") {
    if ($val == "") {
        echo '<title>SpotEasy</title>'; 
    } else {
        echo '<title>SpotEasy - '.getLanguageOn($val).'</title>'; 
    }
    
}

?>