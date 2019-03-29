<?php
    //Fehlermeldung löschen
    $_SESSION['error'] = NULL;
    $invalid = false;
    $benutzername;
    $userid;
    //Wenn der Knopf Login geklickt wurde
    if($_POST['submit_btn'] == "Ändern"){
        $passwort_alt = $_POST['passwort_alt'];
        $passwort_neu = $_POST['passwort_neu'];
        $passwort_neu_repeat = $_POST['passwort_neu_repeat'];

        if(!(empty($passwort_alt)) & !(empty($passwort_neu)) & !(empty($passwort_neu_repeat))){
            $benutzername = $_SESSION['benutzer_app'];
            $dbpasswort = getPasswordByUsername($benutzername);
            $userid = getUserIDByUsername($benutzername);
            
            //passwort verschlüsseln
            $usrpasswort = hash('sha256', $passwort_alt . $benutzername);
            
            //Wenn das alte Passwort mit dem DB Passwort übereinstimmt
            if($usrpasswort == $dbpasswort){
                $invalid = true;
            }

            //Kontrolle für neues Passwort
            if($invalid){
                //ist das wiederholte Passwort gleich, wie das neue
                if($passwort_neu == $passwort_neu_repeat){
                    //Wenn das Passwort einen kleinen Buchstaben beinhaltet
                    if(preg_match('/[a-z]/', $passwort_neu)){
                        //Wenn das Passwort einen grossen Buchstaben beinhaltet
                        if(preg_match('/[A-Z]/', $passwort_neu)){
                            //Wenn das Passwort eine Ziffer beinhaltet
                            if(preg_match('/\d/', $passwort_neu)){
                                //Wenn das passwort 8 Zeichen oder länger ist
                                if(strlen($passwort_neu) >= 8){
                                    updatePasswordByID($userid, $passwort_neu, $benutzername);
                                    $_SESSION['error'] = "changed";
                                }
                                else{
                                    $_SESSION['error'] = "Das neue Passwort muss einen Grossbuchstaben, einen Kleinbuchstaben, eine Ziffer und insgesamt mindestens 8 Zeichen beinhalten!";
                                }
                            }
                            else{
                                $_SESSION['error'] = "Das neue Passwort muss einen Grossbuchstaben, einen Kleinbuchstaben, eine Ziffer und insgesamt mindestens 8 Zeichen beinhalten!";
                            }
                        }
                        else{
                            $_SESSION['error'] = "Das neue Passwort muss einen Grossbuchstaben, einen Kleinbuchstaben, eine Ziffer und insgesamt mindestens 8 Zeichen beinhalten!";
                        }
                    }
                    else{
                        $_SESSION['error'] = "Das neue Passwort muss einen Grossbuchstaben, einen Kleinbuchstaben, eine Ziffer und insgesamt mindestens 8 Zeichen beinhalten!";
                    }
                }
                else{
                    $_SESSION['error'] = "Das wiederholte Passwort entspricht nicht dem Neuen!";
                }
            }
            else{
                $_SESSION['error'] = "Das alte Passwort ist falsch!";
            }
            header('Location: einstellungen');
        }
        else{
            $_SESSION['error'] = "Alle Felder müssen ausgefüllt sein!";
            header('Location: einstellungen');
        }
    }
    else{
        header('Location: home');
    }
?>