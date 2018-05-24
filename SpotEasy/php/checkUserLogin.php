<?php

/**
 * Checkt, ob der Client eingeloggt ist. Diese Funktion wird aufgerufen, wenn der User auf eine Seite will, bei der er eingeloggt sein muss
 * Ist er nicht eingeloggt wird er auf die Login Page weitergeleitet.
 * @param string $hinweis Soll ein Extra Hinweis auf der Login Page erscheinen, wenn er nicht eingeloggt ist, kann dies dieser Funktion übergeben werden.
 */

function checkUserLogin($hinweis = ""){
    if ($hinweis=="") {
        $hinweis = getLanguageOn(43);
    }
    $_SESSION['hinweis']="";
    if (isset($_SESSION['userID'])) {
        if ($_SESSION['userID']==""){
            header("Location: login ");
            $_SESSION['hinweis']=$hinweis;
        }
    }
    else{
        header("Location: login");
        $_SESSION['hinweis']=$hinweis;
    }
}

?>