<?php
    //error session leeren
    $_SESSION['error'] = NULL;
    //wenn der knopf Bearbeiten gedrückt wurde
    if($_POST['submit_btn'] == "Bearbeiten"){
        //session mit der aktivitätsid setzen
        $_SESSION['id_aktivitaet'] = $_POST['id_aktivitaet'];
        //weiterleiten nach aktivitaet_edit.php
        header('Location: aktivitaet_edit');
    }
    //wenn der knopf Löschen gedrückt wurde
    else if($_POST['submit_btn'] == "Löschen"){
        //aktivität via der aktivitätsid in der datenbank löschen
        deleteActivityByID($_POST['id_aktivitaet']);
        //weiterleiten nach aktivitaet_edit_choice.php
        header('Location: aktivitaet_edit_choice');
    }
    else{
        header('Location: home');
    }
?>