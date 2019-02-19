<?php
    //Error Session löschen
    $_SESSION['error'] = NULL;
    //Validierungsvariable
    $invalid = 0;
    $validated = array();

    //Wenn eine Antwort eingegeben wurde
    if(!empty($_POST['antwort'])){
        //Für jede eingegebene Antwort
        foreach($_POST['antwort'] as $antwort){
            //Zum neuen Array hinzufügen
            $validated[] = $antwort;
            //Wenn die Antwort nicht leer ist
            if(!empty($antwort)){
                //die Antwort specialchars validieren
                $antwort = htmlspecialchars($antwort);
                //Wenn die Antwort kürzer oder gliech 300 Zeichen ist
                if(strlen($antwort) <= 300){
                    //Validierungsvariable für diese Antwort erhöhen
                    $invalid += 1;
                }
            }
        }
    }
    //Wenn alle Antworten richtig sind
    if($invalid == count($validated)){
        //Alle Antworten der Feedbackkategorie löschen
        deleteAllOptionsByFeedbackID($_SESSION['id_feedbackkategorie']);
        //Für jede neue Antwortoption
        foreach($validated as $row){
            //specialchars validieren
            $row = htmlspecialchars($row);
            //In Datenbank einfügen
            insertOption($_SESSION['id_feedbackkategorie'], $row);
        }
        header('Location: feedback');
    }
    else{
        $_SESSION['error'] = "Es wurden nicht alle Felder ausgefüllt!";
        header('Location: feedback_add_optionen');
    }
?>