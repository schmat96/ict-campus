<?php 

function getLanguageOn($ele) {
    echo $GLOBALS['language'][$ele];
}

function getLanguageSet() {
    if (isset($GLOBALS['languageSet']) && $GLOBALS['languageSet'] != "") {
        return $GLOBALS['languageSet'];
    } else {
        return "de";
    }
    
}

$GLOBALS['language'] = array();
$GLOBALS['languageSet'] = "";

function loadLanguage() {
    
    
    if (isset($_GET['lang'])) {
        $lang = $_GET['lang'];
        $lang = strtolower($lang);
        switch($lang) {
            case 'ch':
                $GLOBALS['languageSet'] = "ch";
                break;
            case 'en':
                $GLOBALS['languageSet'] = "en";
                break;
            case 'de':
                $GLOBALS['languageSet'] = "de";
                break;
            default:
                $GLOBALS['languageSet'] = "de";
                break;
        }

    } else {
        $GLOBALS['languageSet'] = "de";
    }
    
    require_once 'database.php';
    $database = databaseConnection();
    
    if(!$database)
    {
        exit("Verbindungsfehler: ".mysqli_connect_error());
    } else {
        $abfrage = "SELECT languages_ID as 'id', ".$GLOBALS['languageSet']." as 'lang' FROM `tbl_languages`";
        $ergebnis = mysqli_query($database, $abfrage);
        
        while($row = mysqli_fetch_object($ergebnis))
        {
            $GLOBALS['language'][$row->id] = $row->lang;
            
        }
    }
   
    
    
        
}

?>