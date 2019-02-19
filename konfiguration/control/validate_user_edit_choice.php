<?php
    //Error Session leeren
    $_SESSION['error'] = NULL;
    //Wenn Bearbeiten geklickt wurde
    if($_POST['submit_btn'] == "Bearbeiten"){
        //eine Session aus der UserID machen
        $_SESSION['id_benutzer'] = $_POST['id_benutzer'];
        header('Location: user_edit');
    }      
    //Wenn Löschen geklickt wurde
    else if($_POST['submit_btn'] == "Löschen"){
        //benutzer löschen
        deleteUser($_POST['id_benutzer']);
        header('Location: user_edit_choice');
    }
    else{
        header('Location: home');
    }
?>