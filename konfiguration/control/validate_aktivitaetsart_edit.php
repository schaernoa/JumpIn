<?php
    //Error Session leeren
    $_SESSION['error'] = NULL;
    //Validierungsvariable
    $invalid = false;
    //Variablen für die specialchars validierung
    $aktivitaetsartname;

    //Wenn Ändern geklickt wurde
    if($_POST['submit_btn'] == "Ändern"){
        //Wenn alle benötigten Felder nicht leer sind
        if(!empty($_POST['aktivitaetsartname'])){
            //Den Aktivitätsartnamen specialchars validieren
            $aktivitaetsartname = htmlspecialchars($_POST['aktivitaetsartname']);
            //Wenn der Name kürzer oder gleich 30 Zeichen ist
            if(strlen($aktivitaetsartname) <= 30){
                //Den Datensatz dieser Aktivitätsart aus der Datenbank holen
                $result = getArtByID($_SESSION['id_art']);
                
                //Wenn der neue Name nicht mehr gleich ist
                if($result['name'] != $aktivitaetsartname){
                    //Suche in der Datenbank nach dem neuen Namen
                    $resultatstring = getArtnameByArtname($aktivitaetsartname);
                    //Wenn es diesen Namen noch nicht gibt
                    if ($resultatstring != $aktivitaetsartname){
                        //Eingaben richtig
                        $invalid = true;
                    }
                    else{
                        $_SESSION['error'] = "Aktivitätsart mit diesem Aktivitätsartname existiert bereits!";
                    }
                }
                else{
                    //Eingaben richtig
                    $invalid = true;
                }
            }
            else{
                $_SESSION['error'] = "Der Aktivitätsartname ist zu lang! Max. 30 Zeichen!";
            }
        }
        else{
            $_SESSION['error'] = "Es wurden nicht alle Felder ausgefüllt!";
        }
        //Wenn alle Eingaben richtig sind
        if($invalid){
            $einschreiben;
            //Wenn es eine Aktivitätsart zum einschreiben ist
            if($_POST['einschreiben'] == "true"){
                $einschreiben = 1;
            }
            else{
                $einschreiben = 0;
            }
            //Datensatz in der Datenbank ändern
            updateArtByID($_SESSION['id_art'], $aktivitaetsartname, $einschreiben);
            header('Location: aktivitaetsart_edit_choice');
        }
        else{
            header('Location: aktivitaetsart_edit');
        }
    }
    //Wenn der Zurück Knopf gedrückt wurde
    else if($_POST['submit_btn'] == "Zurück"){
        header('Location: aktivitaetsart_edit_choice');
    }
    else{
        header('Location: home');
    }
?>