<?php
    //Error Session leeren
    $_SESSION['error'] = NULL;
    //Validierungsvariable
    $invalid = false;
    //Variablen für specialchars Validierung
    $name;
    $vorname;
    $benutzername;

    //Wenn Weiter geklickt wurde
    if($_POST['submit_btn'] == "Weiter"){
        //Wenn alle Felder nicht leer sind
        if(!empty($_POST['benutzername']) & !empty($_POST['vorname']) & !empty($_POST['name']) & !empty($_POST['passwort']) & !empty($_POST['passwort2'])){
            //name, vorname und benutzername specialchars validieren
            $name = htmlspecialchars($_POST['name']);
            $vorname = htmlspecialchars($_POST['vorname']);
            $benutzername = htmlspecialchars($_POST['benutzername']);
            //Wenn der benutzername kleiner oder gleich 30 zeichen ist
            if(strlen($benutzername) <= 30){
                //wenn der vorname kleiner oder gleich 50 Zeichen ist
                if(strlen($vorname) <= 50){
                    //Wenn der name kleiner oder gleich 50 Zeichen ist
                    if(strlen($name) <= 50){
                        //Wenn das Passwort einen kleinen Buchstaben beinhaltet
                        if(preg_match('/[a-z]/', $_POST["passwort"])){
                            //Wenn das Passwort einen grossen Buchstaben beinhaltet
                            if(preg_match('/[A-Z]/', $_POST["passwort"])){
                                //Wenn das Passwort eine Ziffer beinhaltet
                                if(preg_match('/\d/', $_POST["passwort"])){
                                    //Wenn das passwort 8 Zeichen oder länger ist
                                    if(strlen($_POST['passwort']) >= 8){ 
                                        //Den Datensatz vom benutzer aus der Datenbank holen
                                        $result = getUserByID($_SESSION['id_benutzer']);
                            
                                        //Wenn der neue benutzername nicht gleich wie der alte ist
                                        if($result['benutzername'] != $benutzername){
                                            //Suche in der Datenbank nach dem neuen benutzernamen
                                            $resultatstring = getUsernameByUsername($benutzername);
                                            //Wenn es noch keinen Benutzer mit diesem benutzernamen gibt
                                            if ($resultatstring != $benutzername){
                                                //Wenn die Passwörter übereinstimmen
                                                if($_POST['passwort'] == $_POST['passwort2']){
                                                    //Eingabe richtig
                                                    $invalid = true;
                                                }
                                                else{
                                                    $_SESSION['error'] = "Passwörter sind nicht identisch!";
                                                }
                                            }
                                            else{
                                                $_SESSION['error'] = "Benutzer mit diesem Benutzernamen existiert bereits!";
                                            }
                                        }
                                        else{
                                            if($_POST['passwort'] == $_POST['passwort2']){
                                                //Eingabe richtig
                                                $invalid = true;
                                            }
                                            else{
                                                $_SESSION['error'] = "Passwörter sind nicht identisch!";
                                            }
                                        }
                                    }
                                    else{
                                        $_SESSION['error'] = "Das Passwort muss einen Grossbuchstaben, einen Kleinbuchstaben, eine Ziffer und insgesamt mindestens 8 Zeichen beinhalten!";
                                    }
                                }
                                else{
                                    $_SESSION['error'] = "Das Passwort muss einen Grossbuchstaben, einen Kleinbuchstaben, eine Ziffer und insgesamt mindestens 8 Zeichen beinhalten!";
                                }
                            }
                            else{
                                $_SESSION['error'] = "Das Passwort muss einen Grossbuchstaben, einen Kleinbuchstaben, eine Ziffer und insgesamt mindestens 8 Zeichen beinhalten!";
                            }
                        }
                        else{
                            $_SESSION['error'] = "Das Passwort muss einen Grossbuchstaben, einen Kleinbuchstaben, eine Ziffer und insgesamt mindestens 8 Zeichen beinhalten!";
                        }
                    }
                    else{
                        $_SESSION['error'] = "Der Name ist zu lang! Max. 50 Zeichen!";
                    }
                }
                else{
                    $_SESSION['error'] = "Der Vorname ist zu lang! Max. 50 Zeichen!";
                }
            }
            else{
                $_SESSION['error'] = "Der Benutzername ist zu lang! Max. 30 Zeichen!";
            } 
        }
        else{
            $_SESSION['error'] = "Es wurden nicht alle Felder ausgefüllt!";
        }
        //Wenn Eingabe richtig
        if($invalid){
            //Ändere den Datensatz des Benutzers
            updateUserByID($_SESSION['id_benutzer'], $_POST['passwort'], $benutzername, $name, $vorname);
            header('Location: user_group_edit');
        }
        else{
            header('Location: user_edit');
        }
    }      
    //Wenn Zurück geklickt wurde
    else if($_POST['submit_btn'] == "Zurück"){
        header('Location: user_edit_choice');
    }
    else{
        header('Location: home');
    }
?>
