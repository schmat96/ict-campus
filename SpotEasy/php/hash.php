<?php
/**
 * Generiert einen random Hash aus den vorgegeben Zeichen. Die Grösse des Strings ist 16.
 * @param unknown $groesse @deprecated
 * @return string Der Zufällig generierte hash.
 */
function randomSalt($groesse) {
    $groesse = 16;
    $text = "QWERTZUIOPASDFGHJKLYXCVBNMqwertzuiopasdfghjklyxcvbnm#=123456789";
    $return = "";
    for ($i=0;$i<$groesse;$i++) {

        $number = rand(0, strlen($text));

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