<?php
    //Error Session leeren
    $_SESSION['error'] = NULL;
    //USerId aus der Session holen
    $benutzerid = (int)$_SESSION['id_benutzer'];

    $iterated = array();
    //Wenn eine Checkbox ausgewählt wurde
    if(!empty($_POST['group'])){
        //Für jede Gecheckte Checkbox
        foreach($_POST['group'] as $checked){
            $idgruppe = getGroupIDByName($checked);
            //Benutzer der Gruppe hinzufügen
            insertUserGroup($idgruppe, $benutzerid);
            $iterated[] = $idgruppe;
        }
    }
    $gruppenabfrage = getAllGroups();
    //Für jede Gruppe
    while($row = mysqli_fetch_array($gruppenabfrage)){
        //Wenn Benutzer der Gruppe zuvor nicht hinzugefügt wurde
        if(!in_array($row['id_gruppe'], $iterated)){
            $gruppeid = $row['id_gruppe'];
            //Gruppe vom benutzer trennen
            deleteUserGroup($gruppeid, $benutzerid);
        }
    }  
    header('Location: user');
?>