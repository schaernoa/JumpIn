<?php
    //Fehlermeldung löschen
    $_SESSION['error'] = NULL;
    $invalid = false;
    $benutzername;
    //Wenn der Knopf Login geklickt wurde
    if($_POST['submit_btn'] == "Login"){
        if(!(empty($_POST['passwort'])) & !(empty($_POST['benutzername']))){
            $benutzername = htmlspecialchars($_POST['benutzername']);
            $dbpasswort = getPasswordByUsername($benutzername);
            //passwort verschlüsseln
            $usrpasswort = hash('sha256', $_POST['passwort'] . $benutzername);
            
            if(empty($dbpasswort)){
                $_SESSION['error'] = "Datenbank antwortet nicht";
                header('Location: login');
            }

            //Wenn die passwörter übereinstimmen
            if($usrpasswort == $dbpasswort){
                $invalid = true;
            }
        }
        if($invalid){
            //wichtige Sessions setzen
            $_SESSION['benutzer_app'] = $benutzername;
            $_SESSION['invalidfiles'] = array("steckbrief_add", "validate_steckbrief_add", "steckbrief_kategorie_add", "validate_steckbrief_kategorie_add", "steckbrief", "steckbrief_view", "validate_steckbrief_order", "validate_steckbrief_loeschen", "einschreiben_choice_aktivitaeten", "einschreiben_choice", "einschreiben", "validate_einschreiben_choice_aktivitaeten", "validate_einschreiben_choice", "validate_einschreiben", "feedback", "feedback_categories", "validate_feedback_categories");
            $_SESSION['notUserUsers'] = array("admin");
            $_SESSION['notGroupGroups'] = array("admin", "alle");
            header('Location: home');
        }
        /*else{
            $_SESSION['error'] = "Unbekannter Benutzername und/oder falsches Passwort!";
            header('Location: login');
        }*/
    }
    else{
        header('Location: home');
    }
?>