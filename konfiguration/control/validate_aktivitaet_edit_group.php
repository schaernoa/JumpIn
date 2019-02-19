<?php
    //error session leeren und die id der zu bearbeitenden aktivität aus der session lesen
    $_SESSION['error'] = NULL;
    $activityid = (int)$_SESSION['id_aktivitaet'];

    //neues leeres array
    $iterated = array();
    //wenn ein häkchen gesetz wurde
    if(!empty($_POST['group'])){
        //für jedes gesetzte häckchen
        foreach($_POST['group'] as $checked){
            //datensatz in datenbank inserten und die gruppenid davon in das erstellte array speichern
            $idgruppe = getGroupIDByName($checked);
            insertActivityGroup($idgruppe, $activityid);
            $iterated[] = $idgruppe;
        }
    }
    $gruppenabfrage = getAllGroups();
    //für alle gruppen
    while($row = mysqli_fetch_array($gruppenabfrage)){
        //wenn die id der gruppe nicht im erstellten array ist
        if(!in_array($row['id_gruppe'], $iterated)){
            //datensatz der gruppe und aktivität in der datenbank löschen
            $gruppeid = $row['id_gruppe'];
            deleteActivityGroup($gruppeid, $activityid);
        }
    } 
    //weiterleiten nach aktivitaet_edit_choice.php
    header('Location: aktivitaet_edit_choice');
?>