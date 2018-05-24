<?php

/**
 * Setzt den Titel für die Webseite. Wird keine ID für die Language angegeben, wird einfach SpotEasy geschrieben
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