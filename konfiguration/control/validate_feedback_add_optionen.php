<?php
    //Error Session leeren
    $_SESSION['error'] = NULL;
    //Validationsvariable
    $invalid = 0;
    $iterated = array();

    //wenn die Antwort nicht leer ist
    if(!empty($_POST['antwort'])){
        //Für jede gegebene Antwort
        foreach($_POST['antwort'] as $antwort){
            //die Antwort am neuen Array hinzufügen
            $iterated[] = $antwort;
            //Wenn die Antwort nicht leer ist
            if(!empty($antwort)){
                //Antwort specailchars validieren
                $antwort = htmlspecialchars($antwort);
                //Wenn die Antwort kürzer oder gleich 300 Zeichen ist
                if(strlen($antwort) <= 300){
                    //Eine Antwort mehr richtig
                    $invalid += 1;
                }
            }
        }
    }
    //Wenn alle Antworten richtig sind
    if($invalid == count($iterated)){
        //Für jede Antwort
        foreach($iterated as $row){
            //Antwort specialchars validieren
            $row = htmlspecialchars($row);
            //Antwort in Datenbank einfügen
            insertOption($_SESSION['feedback_add'], $row);
        }
        header('Location: feedback');
    }
    else{
        $_SESSION['error'] = "Es wurden nicht alle Felder ausgefüllt!";
        header('Location: feedback_add_optionen');
    }
?>