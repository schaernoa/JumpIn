<?php
    //Fehlermeldung löschen
    $_SESSION['error'] = NULL;
    //Wenn der Löschen Knopf geklickt wurde
    if($_POST['submit_btn'] == "Löschen"){
        deleteCharacteristicsCategoryByID($_POST['kategorielöschen']);
        header('Location: steckbrief_view');
    }
    else{
        header('Location: steckbrief');
    }
?>