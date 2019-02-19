<?php
    //Error Session leeren
    $_SESSION['error'] = NULL;
    //Validierungsvariable setzen
    $invalid = false;
    //Variable um specialchars zu validieren
    $frage;

    //Wenn Weiter geklickt wurde
    if($_POST['submit_btn'] == "Weiter"){
        //Wenn alle benötigten Felder ausgefüllt wurden
        if(!empty($_POST['frage']) & !empty($_POST['anzahloptionen']) & !empty($_POST['aufschaltsdate']) & !empty($_POST['aufschaltszeit'])){
            //die frage specialchars validieren
            $frage = htmlspecialchars($_POST['frage']);
            //wenn die frage kürzer oder gleich 300 Zeichen ist
            if(strlen($frage) <= 300){
                //Wenn die Anzahloptionen eine ganze Zahl ist
                if(ctype_digit($_POST['anzahloptionen'])){
                    //alle Eingaben richtig
                    $invalid = true;
                }
                else{
                    $_SESSION['error'] = "Anzahloptionen muss eine Zahl sein! Gibt an wie viele Antwortoptionen anschliessend ausgefüllt werden müssen!";
                }            
            }
            else{
                $_SESSION['error'] = "Die Frage des Feedbacks ist zu lang! Max. 300 Zeichen!";
            }
        }
        else{
            $_SESSION['error'] = "Es wurden nicht alle Felder ausgefüllt!";
        }
        //Wenn alle Eingaben Richtig
        if($invalid){
            //Feedbackkategorie in Datenbank einfügen
            insertFeedbackCategory($frage, $_POST['anzahloptionen'], validateDateTime($_POST['aufschaltsdate'], $_POST['aufschaltszeit']));
            header('Location: feedback_add_optionen');
        }
        else{
            header('Location: feedback_add');
        }
    }      
    else if($_POST['submit_btn'] == "Zurück"){
        header('Location: feedback');
    }
    else{
        header('Location: home');
    }
?>