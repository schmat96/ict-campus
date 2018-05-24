<?php

/**
 * Gibt den String des �bersetzen Wortes zur�ck aus den Globals.
 * @param int $ele
 * @return String �bersetztes Wort. "no translation found" fall es nicht gesetzt wurde.
 */
function getLanguageOn($ele)
{
    if (isset($GLOBALS['language'][$ele])) {
        return $GLOBALS['language'][$ele];
    } else {
        return "no translation found";
    }
}

/**
 * Gibt die Sprach-Settings aus der Session Variable zur�ck.
 * "de" ist der default wert
 * @deprecated
 * @return string Langauage Settings.
 */
function getLanguageSet()
{
    if (isset($_SESSION['languageSet']) && $_SESSION['languageSet'] != "") {
        return $_SESSION['languageSet'];
    } else {
        return "de";
    }
}

/**
 * Extrem h�sslich.
 * 
 * @var Ambiguous $GLOBALS
 */
$GLOBALS['language'] = array();

/**
 * Laded die W�rter aus der Datenbank.
 */
function loadLanguage()
{
    /**
     * Zuerst wird �berpr�ft ob die GET Variable gesetzt wurde (sollte immer st�rker sein als $_SESSION['language'])
     */
    if (isset($_GET['lang'])) {
        $lang = $_GET['lang'];
        $lang = strtolower($lang);
        switch ($lang) {
            case 'ch':
                $_SESSION['languageSet'] = "ch";
                break;
            case 'en':
                $_SESSION['languageSet'] = "en";
                break;
            case 'de':
                $_SESSION['languageSet'] = "de";
                break;
            default:
                $_SESSION['languageSet'] = "de";
                break;
        }
     /**
      * Falls nicht wird noch die SESSION �berpr�ft, ansosnten kommt der default wert.
      */
    } elseif (isset($_SESSION['languageSet'])) {
        if ($_SESSION['languageSet'] == "") {
            $_SESSION['languageSet'] = "de";
        }
    } else {
        $_SESSION['languageSet'] = "de";
    }
    
    /**
     * Jetzt werden die W�rter geladen
     */
    require_once 'database.php';
    $database = databaseConnection();
    
    if (! $database) {
        exit("Verbindungsfehler: " . mysqli_connect_error());
    } else {
        $abfrage = "SELECT languages_ID as 'id', " . $_SESSION['languageSet'] . " as 'lang' FROM `tbl_languages`";
        $ergebnis = mysqli_query($database, $abfrage);
        
        while ($row = mysqli_fetch_object($ergebnis)) {
            $GLOBALS['language'][$row->id] = $row->lang;
        }
    }
}

?>