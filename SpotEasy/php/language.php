<?php 

function getLanguageOn($ele) {
    echo $GLOBALS['language'][$ele];
}

$GLOBALS['language'] = array();

function loadLanguage() {
    
    $languageSet = "";
    if (isset($_GET['lang'])) {
        $lang = $_GET['lang'];
        $lang = strtolower($lang);
        switch($lang) {
            case 'ch':
                $languageSet = "ch";
                break;
            case 'en':
                $languageSet = "en";
                break;
            case 'de':
                $languageSet = "de";
                break;
            default:
                $languageSet = "de";
                break;
        }

    } else {
        $languageSet = "de";
    }
    switch($languageSet) {
        case 'ch':
            array_push($GLOBALS['language'], "Deheime", "Versteck dini Siite");
            break;
        case 'en':
            array_push($GLOBALS['language'], "Home", "Cover your Page");
            break;
        case 'de':
            array_push($GLOBALS['language'], 'Zuhause');
            array_push($GLOBALS['language'], "Verstecke deine Seite");
            break;
    }
   
    
    
        
}

?>