<?php

/**
 * Setzt den Titel f�r die Webseite. Wird keine ID f�r die Language angegeben, wird einfach SpotEasy geschrieben
 * @param string $val
 */
function setTitle($val = "")
{
    if ($val == "") {
        echo '<title>SpotEasy</title>';
    } else {
        echo '<title>SpotEasy - ' . getLanguageOn($val) . '</title>';
    }
}

?>