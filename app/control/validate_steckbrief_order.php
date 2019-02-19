<?php
    //Fehlermeldung löschen
    $_SESSION['error'] = NULL;
    //Wenn der Knopf Ändern geklickt wurde
    if($_POST['submit_btn'] == "Ändern"){
        //Wenn nicht keine Gruppe ausgewählt wurde
        if($_POST['gruppe'] != "null"){
            $_SESSION['groupselected'] = $_POST['gruppe'];
        }
        else{
            $_SESSION['groupselected'] = 0;
        }
        header('Location: steckbrief');
    }
    else{
        header('Location: home');
    }
?>