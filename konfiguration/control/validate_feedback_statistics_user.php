<?php
    //Error Session leeren
    $_SESSION['error'] = NULL;

    //Wenn zurück geklickt wurde
    if($_POST['submit_btn'] == "Zurück"){
        header('Location: feedback_statistics');
    }   
    else{
        header('Location: home');
    }
?>