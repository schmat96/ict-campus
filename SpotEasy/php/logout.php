<?php
/**
 * Loggt den User aus und geht zurück auf home
 */
function logout() {
    $_SESSION['userID'] = "";
    header('Location: home');
}

?>