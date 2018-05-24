<?php

//Funktion um gewisse Sonderzeichen etc von Usereingaben abzutrennen (Anti-Hacker)
function htmlEscapses($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>