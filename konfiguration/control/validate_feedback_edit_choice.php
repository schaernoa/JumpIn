<?php
    //Error Session leeren
    $_SESSION['error'] = NULL;
    //Wenn Bearbeiten geklickt wurde
    if($_POST['submit_btn'] == "Bearbeiten"){
        //die FeedbackkategorieID zu einer Session machen
        $_SESSION['id_feedbackkategorie'] = $_POST['id_feedbackkategorie'];
        header('Location: feedback_edit');
    }
    //Wenn Löschen geklickt wurde
    else if($_POST['submit_btn'] == "Löschen"){
        //Feedbackkategorie und alle Optionen löschen
        deleteFeedbackCategoryByID($_POST['id_feedbackkategorie']);
        header('Location: feedback_edit_choice');
    }
    else{
        header('Location: home');
    }
?>