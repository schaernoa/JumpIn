<?php
    //Error Session leeren
    $_SESSION['error'] = NULL;
    //Wenn Bearbeiten geklickt wurde
    if($_POST['submit_btn'] == "Bearbeiten"){
        //die GruppenID zu einer Session machen
        $_SESSION['id_gruppe'] = $_POST['id_gruppe'];
        header('Location: group_edit');
    }
    //Wenn Löschen geklickt wurde 
    else if($_POST['submit_btn'] == "Löschen"){
        //Die Gruppe Löschen
        deleteGroupByID($_POST['id_gruppe']);
        header('Location: group_edit_choice');
    }
    else{
        header('Location: home');
    }
?>