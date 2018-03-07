<?php 

function getLanguageOn($ele) {
    return $GLOBALS['language'][$ele];
}

function getLanguageSet() {
    
    if (isset($_SESSION['languageSet']) && $_SESSION['languageSet'] != "") {
        return $_SESSION['languageSet'];
    } else {
        return "de";
    }
    
}

$GLOBALS['language'] = array();

function loadLanguage() {

    if (isset($_GET['lang'])) {
       
            $lang = $_GET['lang'];
            $lang = strtolower($lang);
            switch($lang) {
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
   

    } elseif (isset($_SESSION['languageSet'])) {
        if ($_SESSION['languageSet']=="") {
            $_SESSION['languageSet'] = "de";
        }
    } else {
        $_SESSION['languageSet'] = "de";
    }
    
    require_once 'database.php';
    $database = databaseConnection();
    
    if(!$database)
    {
        exit("Verbindungsfehler: ".mysqli_connect_error());
    } else {
        $abfrage = "SELECT languages_ID as 'id', ".$_SESSION['languageSet']." as 'lang' FROM `tbl_languages`";
        $ergebnis = mysqli_query($database, $abfrage);
        
        while($row = mysqli_fetch_object($ergebnis))
        {
            $GLOBALS['language'][$row->id] = $row->lang;
        }
    }
   
    
    
        
}

?>