<?php
    //Error Session leeren
    $_SESSION['error'] = NULL;
    //Validierungsvariable
    $invalid = false;
    //Variablen um specialchars zu validieren
    $frage;

    //Wenn Weiter geklickt wurde
    if($_POST['submit_btn'] == "Weiter"){
        //Wenn alle Felder nicht leer sind
        if(!empty($_POST['frage']) & !empty($_POST['anzahloptionen']) & !empty($_POST['aufschaltsdate']) & !empty($_POST['aufschaltszeit'])){
            //die frage specialchars validieren
            $frage = htmlspecialchars($_POST['frage']);
            //Wenn die Frage kürzer oder gleich 300 zeichen ist
            if(strlen($frage) <= 300){
                //Wenn die Anzahloptionen eine ganze Zahl ist
                if(ctype_digit($_POST['anzahloptionen'])){
                    //Alle Eingaben richtig
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
        //Wenn alle Eingaben richtig
        if($invalid){
            //Den Feedback Kategorie Datensatz ändern
            updateFeedbackCategory($_SESSION['id_feedbackkategorie'], $frage, $_POST['anzahloptionen'], validateDateTime($_POST['aufschaltsdate'], $_POST['aufschaltszeit']));
            header('Location: feedback_edit_optionen');
        }
        else{
            header('Location: feedback_edit');
        }
    }
    //Wenn Zurück geklickt wurde  
    else if($_POST['submit_btn'] == "Zurück"){
        header('Location: feedback_edit_choice');
    }
    else{
        header('Location: home');
    }
?>