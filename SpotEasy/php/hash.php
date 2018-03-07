<?php
function randomSalt($groesse) {
    $groesse = 16;
    $text = "QWERTZUIOPASDFGHJKLYXCVBNMqwertzuiopasdfghjklyxcvbnm#=123456789";
    $return = "";
    for ($i=0;$i<$groesse;$i++) {
        $number = random_int(0, strlen($text));
        $substring = $text[$number];
        $return = $return.$substring;
    }
    return $return;
}

function hashfunction($password, $salt){
    $pwsalt = $password.$salt;
    $hashpw = hash('sha256', $pwsalt, false);
    return $hashpw;
}

?>