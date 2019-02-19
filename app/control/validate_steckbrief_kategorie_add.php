<?php
    //Fehlermeldung löschen
    $_SESSION['error'] = NULL;
    $validated = false;
    $steckbriefkategoriename;
    $antwort;

    //Wenn der knopf Erstellen geklickt wurde
    if($_POST['submit_btn'] == "Erstellen"){
        $einzeiler = 1;
        if(!empty($_POST['steckbriefkategoriename']) & !empty($_POST['einzeiler'])  & !empty($_POST['antwort'])){
            $steckbriefkategoriename = htmlspecialchars($_POST['steckbriefkategoriename']);
            //specialchars validierung
            $antwort = htmlspecialchars($_POST['antwort']);
            if(strlen($steckbriefkategoriename) <= 30){
                if(strlen($antwort) <= 300){
                    //Wenn es kein einzeiler ist
                    if($_POST['einzeiler'] == "false"){
                        $einzeiler = 0;
                    }
                    $validated = true;
                }
                else{
                    $_SESSION['error'] = "Deine Antwort ist zu lang! Max. 300 Zeichen.";
                }
            }
            else{
                $_SESSION['error'] = "Der Steckbriefkategoriename ist zu lang! Max. 30 Zeichen.";
            }
        }
        else{
            $_SESSION['error'] = "Es wurden nicht alle Felder ausgefüllt!";
        }
        //wenn richtig validiert
        if($validated){
            $id = insertCharacteristicsCategory($steckbriefkategoriename, 0, $einzeiler);
            insertCharacteristics($id, getUserIDByUsername($_SESSION['benutzer_app']), $antwort);
            $array = array("steckbrief_kategorie_add", "validate_steckbrief_kategorie_add", "steckbrief", "steckbrief_view", "validate_steckbrief_order", "validate_steckbrief_loeschen");
            removeSessionInvalid($array);
            $array2 = array("steckbrief_add", "validate_steckbrief_add");
            addSessionInvalid($array2);
            header('Location: steckbrief_view');
        }
        else{
            header('Location: steckbrief_kategorie_add');
        }
    }
    else{
        header('Location: home');
    }
?>