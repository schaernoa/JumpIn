<?php
    //Fehlermeldung löschen
    $_SESSION['error'] = NULL;
    //Wenn der Knopf Zurück geklickt wurde
    if($_POST['submit_btn'] == "Zurück"){
        header('Location: wochenplan');
    }
    else{
        header('Location: home');
    }
?>