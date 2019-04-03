<?php
    //Fehlermeldung löschen
    $_SESSION['error'] = NULL;
    //Wenn der Zurückknopf geklickt worden ist
    if($_POST['submit_btn'] == "Zurück"){
        if($_SESSION['previous'] == "wochenplan"){
            header('Location: wochenplan');
        }
        else if($_SESSION['previous'] == "choice"){
            header('Location: einschreiben_choice');
        }
        else{
            header('Location: wochenplan');
        }
        $_SESSION['previous'] = NULL;
    }
    else{
        header('Location: home');
    }
?>