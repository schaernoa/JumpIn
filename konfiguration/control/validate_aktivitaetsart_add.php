<?php
    //Error Session leeren
    $_SESSION['error'] = NULL;
    //Validierungsvariabble
    $invalid = false;
    //Variable für die htmlspecialchars Validierung
    $aktivitaetsartname;

    //Wenn der knopf Erstellen gedrückt wurde
    if($_POST['submit_btn'] == "Erstellen"){
        //Wenn alle benötigten Felder nicht leer sind
        if(!empty($_POST['aktivitaetsartname'])){
            //den Aktivitätsartnamen nach specialchars validieren
            $aktivitaetsartname = htmlspecialchars($_POST['aktivitaetsartname']);
            //Wenn der Name kürzer oder gleich 30 Zeichen ist
            if(strlen($aktivitaetsartname) <= 30){
                //Suche in der Datenbank nach diesem Aktivitätsartnamen              
                $dbArtname = getArtnameByArtname($aktivitaetsartname);

                //Wenn es diesen Namen noch nicht gibt
	            if ($dbArtname != $aktivitaetsartname){
                    //Eingaben richtig
                    $invalid = true;
                }
                else{
                    $_SESSION['error'] = "Aktivitätsart mit diesem Aktivitätsartname existiert bereits!";
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
            else if($_POST['einschreiben'] == "false"){
                $einschreiben = 0;
            }
            insertArt($aktivitaetsartname, $einschreiben);
            header('Location: aktivitaetsart');
        }
        else{
            header('Location: aktivitaetsart_add');
        }
    }
    //Wenn Zurück geklickt wurde
    else if($_POST['submit_btn'] == "Zurück"){
        header('Location: aktivitaetsart');
    }
    else{
        header('Location: home');
    }
?>