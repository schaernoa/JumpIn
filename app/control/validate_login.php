<?php
    //Fehlermeldung löschen
    $_SESSION['error'] = NULL;
    $invalid = false;
    $benutzername;
    //Wenn der Knopf Login geklickt wurde
    if($_POST['submit_btn'] == "Login"){
        if(!(empty($_POST['passwort'])) & !(empty($_POST['benutzername']))){
            $benutzername = htmlspecialchars(strtolower($_POST['benutzername']));
            $dbpasswort = getPasswordByUsername($benutzername);
            //passwort verschlüsseln
            $usrpasswort = hash('sha256', $_POST['passwort'] . $benutzername);
            
            //Wenn die passwörter übereinstimmen
            if($usrpasswort == $dbpasswort){
                $invalid = true;
            }
            if($invalid){
                //wichtige Sessions setzen
                $_SESSION['benutzer_app'] = $benutzername;
                $_SESSION['Coach'] = isUserInGroup(getUserIDByUsername($_SESSION['benutzer_app']),"Coach");
                $_SESSION['invalidfiles'] = array("steckbrief_add", "validate_steckbrief_add", "steckbrief_kategorie_add", "validate_steckbrief_kategorie_add", "steckbrief", "steckbrief_view", "validate_steckbrief_order", "validate_steckbrief_loeschen", "einschreiben_choice_aktivitaeten", "einschreiben_choice", "einschreiben", "validate_einschreiben_choice_aktivitaeten", "validate_einschreiben_choice", "validate_einschreiben", "feedback", "feedback_categories", "validate_feedback_categories");
                $_SESSION['notUserUsers'] = array("admin");
                $_SESSION['notGroupGroups'] = array("admin", "alle");
                header('Location: home');
    
                //Session des fehlgeschlagenen Logins löschen
                $_SESSION['error_login'] = null;
            }
            else{
                //Fehlermeldung in error-Session speichern
                if(isDatabaseReachable()){
                    if(empty(getUserIDByUsername($benutzername))){
                        $_SESSION['error'] = "Kein Benutzer mit diesem Benutzernamen vorhanden!";
                        $_SESSION['error_login'] = null;
                        header('Location: login');
                    }
                    else{
                        $_SESSION['error'] = "Falsches Passwort!";
                        $_SESSION['error_login'] = $benutzername;
                        header('Location: login');
                    }
                }
                else{
                    $_SESSION['error'] = "Database is unreachable - Login not possible!";
                    $_SESSION['error_login'] = $benutzername;
                    header('Location: login');
                }
            }
        }
        else{
            //Fehler in error-Session speichern, und Benutzername zurückschicken
            $_SESSION['error'] = "Felder müssen ausgefüllt sein!";
            header('Location: login');
        }
    }
    else{
        header('Location: home');
    }
?>