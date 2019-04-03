<?php
    //Fehlermeldung löschen
    $_SESSION['error'] = NULL;
    //Wenn der Zurückknopf geklickt worden ist
    if($_POST['submit_btn'] == "Zurück"){
        header('Location: home');
    }
    else{
        header('Location: home');
    }
?>