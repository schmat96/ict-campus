<?php
/**
 * Loggt den User aus und geht zur�ck auf home
 */
function logout() {
    $_SESSION['userID'] = "";
    header('Location: home');
}

?>