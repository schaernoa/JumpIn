<?php
    //Error Session leeren
    $_SESSION['error'] = NULL;
    if(!empty($_POST['id_user'])){
        $array = array();
        //Neu erlaubte Seiten
        array_push($array, "steckbrief_view", "validate_steckbrief_loeschen", "steckbrief_kategorie_add", "validate_steckbrief_kategorie_add");
        removeSessionInvalid($array);
        //Neu Verbotene Seiten
        $array2 = array("steckbrief_add", "validate_steckbrief_add",  "validate_steckbrief_order", "steckbrief");
        addSessionInvalid($array2);
        $_SESSION['steckbrief_id'] = $_POST['id_user'];
        $_SESSION['mode'] = $_POST['mode'];
        header('Location: steckbrief_view');
    }
    else{
        header('Location: home');
    }
?>