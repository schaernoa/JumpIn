<?php
    //Error Session leeren
    $_SESSION['error'] = NULL;
    $characteristics = 0;
    $array = array();
    $id=getUserIDByUsername($_SESSION['benutzer_app']);
    $allcharacteristics = getCharacteristicsByUserID($id);
    //Zähle die Anzahl ausgefüllten Steckbriefkategorien
    while($row = mysqli_fetch_assoc($allcharacteristics)){
        $characteristics++;
    }

    //Wenn diese nicht mehr als 0 sind
    if(!$characteristics > 0){
        array_push($array, "steckbrief_add", "validate_steckbrief_add");
        removeSessionInvalid($array);
        $array2 = array("steckbrief_kategorie_add", "validate_steckbrief_kategorie_add", "steckbrief", "steckbrief_view", "validate_steckbrief_order", "validate_steckbrief_loeschen");
        addSessionInvalid($array2);
        header('Location: steckbrief_add');
    }
    else{
        $characteristics = 0;
        $obligationcharacteristics = getCharacteristicsByObligationAndID($id);
        //Zähle die Anzahl nicht obligatorischen ausgefüllten Steckbriefkategorien
        while($row = mysqli_fetch_assoc($obligationcharacteristics)){
            $characteristics++;
        }
        //Wenn diese nicht mehr als 0 sind
        if(!$characteristics > 0){
            array_push($array, "steckbrief_kategorie_add", "validate_steckbrief_kategorie_add");
            removeSessionInvalid($array);
            $array2 = array("steckbrief_add", "validate_steckbrief_add", "steckbrief", "steckbrief_view", "validate_steckbrief_order", "validate_steckbrief_loeschen");
            addSessionInvalid($array2);
            header('Location: steckbrief_kategorie_add');
        }
        else{
            array_push($array, "steckbrief_kategorie_add", "validate_steckbrief_kategorie_add", "steckbrief", "steckbrief_view", "validate_steckbrief_order", "validate_steckbrief_loeschen");
            removeSessionInvalid($array);
            $array2 = array("steckbrief_add", "validate_steckbrief_add");
            addSessionInvalid($array2);
            header('Location: steckbrief');
        }
    }
?>