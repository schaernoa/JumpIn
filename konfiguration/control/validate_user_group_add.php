<?php
    //Error Session leeren
    $_SESSION['error'] = NULL;
    //USerID aus Session holen
    $benutzerid = (int)$_SESSION['user_add'];

    //Wenn Zurück geklickt wurde
    if($_POST['submit_btn'] == "Zurück"){
        //Benutzer Löschen
        deleteUser($benutzerid);
        header('Location: user_add');
    }
    //Wenn Erstellen geklickt wurde
    else if($_POST['submit_btn'] == "Erstellen"){
        //Wenn eine Checkbox gecheckt wurde
        if(!empty($_POST['group'])){
            //Für jede ausgewählte Gruppe
            foreach($_POST['group'] as $checked){
                $resultatstring = getGroupIDByName($checked);
                //Benutzer der Gruppe hinzufügen
                insertUserGroup($resultatstring, $benutzerid);
            }
        }
        header('Location: user');
    }
?>