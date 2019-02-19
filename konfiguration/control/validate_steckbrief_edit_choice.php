<?php
    //Error Session leeren
    $_SESSION['error'] = NULL;
    //Wenn Bearbeiten geklickt wurde
    if($_POST['submit_btn'] == "Bearbeiten"){
        //SteckbriefkategorieID zu einer Session machen
        $_SESSION['id_steckbriefkategorie'] = $_POST['id_steckbriefkategorie'];
        header('Location: steckbrief_edit');
    }      
    //Wenn löschen geklickt wurde
    else if($_POST['submit_btn'] == "Löschen"){
        //Diese Steckbriefkategorie löschen
        deleteSteckbriefkategorieByID($_POST['id_steckbriefkategorie']);
        header('Location: steckbrief_edit_choice');
    }
    else{
        header('Location: home');
    }
?>