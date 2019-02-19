<?php
    //Error Session leeren
    $_SESSION['error'] = NULL;
    //Wenn Bearbeiten geklickt wurde
    if($_POST['submit_btn'] == "Bearbeiten"){
        //die Aktivitätsart zu einer Session machen
        $_SESSION['id_art'] = $_POST['id_art'];
        header('Location: aktivitaetsart_edit');
    }
    //Wenn Löschen geklickt wurde
    else if($_POST['submit_btn'] == "Löschen"){
        //die Aktivitätsart löschen
        deleteArtByID($_POST['id_art']);
        header('Location: aktivitaetsart_edit_choice');
    }
    else{
        header('Location: home');
    }
?>