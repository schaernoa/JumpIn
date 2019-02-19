<?php
    //Error Session leeren
    $_SESSION['error'] = NULL;
    //Validierungsvariable
    $invalid = false;
    //Variable um den Namen nach Specialchars zu validieren
    $name;

    //Wenn Ändern geklickt wurde
    if($_POST['submit_btn'] == "Ändern"){
        //Wenn alle notwendigen Felder nicht leer sind
        if(!empty($_POST['name']) & !empty($_POST['writeindate']) & !empty($_POST['writeintime'])){
            //den Namen nach Specialchars validieren
            $name = htmlspecialchars($_POST['name']);
            //Wenn der name kürzer oder gleich 30 zeichen ist
            if(strlen($name) <= 30){
                //Wenn eine Aktivitätsart ausgewählt wurde
                if($_POST['aktivitaetsart'] != "null"){
                    //In der Datenbank den Datensatz dieses Aktivitätblockes holen
                    $result = getActivityentityByID($_SESSION['id_aktivitaetblock']);
                
                    //wenn der neue Name ungleich dem Alten ist
                    if($result['name'] != $name){
                        //Suche in der Datenbank nach dem neuen Namen
                        $resultatstring = getActivityentitynameByName($name);
                        //Wenn es diesen Namen noch nicht gibt
                        if ($resultatstring != $name){
                            //Eingaben richtig
                            $invalid = true;
                        }
                        else{
                            $_SESSION['error'] = "Aktivitätsblock mit diesem Aktivitätsblockname existiert bereits!";
                        }
                    }
                    else{
                        //Eingaben richtig
                        $invalid = true;
                    }
                }
                else{
                    $_SESSION['error'] = "Es wurde keine Aktivitätsart ausgewählt!";
                }       
            }
            else{
                $_SESSION['error'] = "Der Aktivitätsblockname ist zu lang! Max. 30 Zeichen!";
            } 
        }
        else{
            $_SESSION['error'] = "Es wurden nicht alle Felder ausgefüllt!";
        }
        //Wenn alle Eingaben richtig sind
        if($invalid){
            //Den Aktivitätsartnamen nach specialchars validieren
            $aktivitaetsartname = htmlspecialchars($_POST['aktivitaetsart']);
            //den Aktivitätblock in der Datenbank ändern
            updateActivityentity($_SESSION['id_aktivitaetblock'], $name, getArtIDByName($aktivitaetsartname), validateDateTime($_POST['writeindate'], $_POST['writeintime']));
            header('Location: aktivitaetblock_edit_choice');
        }
        else{
            header('Location: aktivitaetblock_edit');
        }
    }
    //Wenn Zurück geklickt wurde
    else if($_POST['submit_btn'] == "Zurück"){
        header('Location: aktivitaetblock_edit_choice');
    }
    else{
        header('Location: home');
    }
?>