<?php
    //error session leeren
    $_SESSION['error'] = NULL;
    //aktivitaetid der zu bearbeitenden aktivität aus der session holen 
    $aktivitaetid = $_SESSION['activity_add'];

    //wenn eine gruppe angekreuzt wurde
    if(!empty($_POST['group'])){
        //für jede angeklickte gruppe
        foreach($_POST['group'] as $checked){
            //gruppenname via gruppenid aus der datenbank holen
            $resultatstring = getGroupIDByName($checked);
            //aktivität_gruppe in datenbank inserten
            insertActivityGroup($resultatstring, $aktivitaetid);
        }
    }
    //weiterleiten nach aktivitaet.php
    header('Location: aktivitaet');

?>