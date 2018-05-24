<?php
/**
 * Speichert die Session Variabeln für die Email und das Passwort.
 * So kann der User das Registrierungsformular bei veränderung der Sprachen mit den gleichen Werten wiederverwenden.
 * 
 */
if (isset($_POST["email"])) {
    $_SESSION['email'] = $_POST["email"];
}

if (isset($_POST["password1"])) {
    $_SESSION['password1'] = $_POST["pw1"];
}

if (isset($_POST["pw2"])) {
    $_SESSION['password2'] = $_POST["pw2"];
}

?>