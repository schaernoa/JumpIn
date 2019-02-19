<?php
    //Error Session leeren
    $_SESSION['error'] = NULL;
    //Wenn Bearbeiten geklickt wurde
    if($_POST['submit_btn'] == "Bearbeiten"){
        //die Notfallkategorieid zu einer Session machen
        $_SESSION['id_notfallkategorie'] = $_POST['id_notfallkategorie'];
        header('Location: notfallkarte_edit');
    }      
    //Wenn Löschen geklickt wurde
    else if($_POST['submit_btn'] == "Löschen"){
        //die Notfallkategorie löschen
        deleteEmergencyCategoryByID($_POST['id_notfallkategorie']);
        header('Location: notfallkarte_edit_choice');
    }
    else{
        header('Location: home');
    }
?>