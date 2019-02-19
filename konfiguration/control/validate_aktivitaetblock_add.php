<?php
    //Error Session leeren
    $_SESSION['error'] = NULL;
    //Validierungsvariable
    $invalid = false;
    //Variable für html-specialchars validierung
    $name;

    //Wenn auf der vorderen Seite der Submit-Button Erstellen gedrückt wurde
    if($_POST['submit_btn'] == "Erstellen"){
        //Wenn alle benötigten Felder nicht leer sind
        if(!empty($_POST['name']) & !empty($_POST['writeindate']) & !empty($_POST['writeintime'])){
            //htmlspecialchars validieren
            $name = htmlspecialchars($_POST['name']);
            //Wenn der name kürzer oder gleich als 20 ist
            if(strlen($name) <= 30){ 
                //Wenn es eine Aktivitätsart ausgewählt wurde 
                if($_POST['aktivitaetsart'] != "null"){
                    //Aktivitätsblock nach dem neuen Namen holen
                    $dbname = getActivityentitynameByName($name);

                    //Wenn es noch keinen gleichnamigen Aktivitätsblock gibt
                    if ($dbname != $name){
                        //eingaben korrekt
                        $invalid = true;
                    }
                    else{
                        $_SESSION['error'] = "Aktivitätsblock mit diesem Aktivitätsblockname existiert bereits!";
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
        //Wenn eingaben korrekt
        if($invalid){
            //aktivitätsartname specialchars validieren
            $aktivitaetsartname = htmlspecialchars($_POST['aktivitaetsart']);
            //Den Aktivitätsblock erstelklen
            insertActivityentity($name, getArtIDByName($aktivitaetsartname), validateDateTime($_POST['writeindate'], $_POST['writeintime']));
            header('Location: aktivitaetblock');
        }
        else{
            header('Location: aktivitaetblock_add');
        }
    }
    //Wenn auf der vorderen Seite der Submit button Zurück geklickt wurde
    else if($_POST['submit_btn'] == "Zurück"){
        header('Location: aktivitaetblock');
    }
    else{
        header('Location: home');
    }
?>