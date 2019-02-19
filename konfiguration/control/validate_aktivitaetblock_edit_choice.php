<?php
    //Error Session leeren
    $_SESSION['error'] = NULL;
    //Wenn auf der vorderen Seite der Submit Button Bearbeiten geklickt wurde
    if($_POST['submit_btn'] == "Bearbeiten"){
        //den Aktivitätsblock in einer Session speichern
        $_SESSION['id_aktivitaetblock'] = $_POST['id_aktivitaetblock'];
        header('Location: aktivitaetblock_edit');
    }
    //Wenn Löschen geklickt wurde
    else if($_POST['submit_btn'] == "Löschen"){
        //Aktivitätblock löschen
        deleteActivityentityByID($_POST['id_aktivitaetblock']);
        header('Location: aktivitaetblock_edit_choice');
    }
    else{
        header('Location: home');
    }
?>