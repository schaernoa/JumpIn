<?php
    //Error Session leeren
    $_SESSION['error'] = NULL;
    //Validierungsvariable
    $invalid = false;
    //Variablen für specialchars Validation
    $name;
    $vorname;
    $benutzername;

    //Wenn Erstellen geklickt wurde
    if($_POST['submit_btn'] == "Erstellen"){
        //Wenn alle Felder nicht leer sind
        if(!empty($_POST['benutzername']) & !empty($_POST['vorname']) & !empty($_POST['name']) & !empty($_POST['passwort']) & !empty($_POST['passwort2'])){
            //Name vorname und benutzername specialchars validieren
            $name = htmlspecialchars($_POST['name']);
            $vorname = htmlspecialchars($_POST['vorname']);
            $benutzername = htmlspecialchars($_POST['benutzername']);
            //Wenn der benutzername kleiner oder gleich 30 zeichen ist
            if(strlen($benutzername) <= 30){
                //Wenn der Vorname kleiner oder gleich 50 Zeichen ist
                if(strlen($vorname) <= 50){
                    //Wenn der name kleiner oder gleich 50 Zeichen ist
                    if(strlen($name) <= 50){
                        //Wenn es ein Kleinbuchstaben im passwort hat
                        if(preg_match('/[a-z]/', $_POST["passwort"])){
                            //Wenn es einen Grossbuchstaben im Passwort hat
                            if(preg_match('/[A-Z]/', $_POST["passwort"])){
                                //Wenn es eine ziffer im Passwort hat
                                if(preg_match('/\d/', $_POST["passwort"])){
                                    //Wenn das Passwort länger oder gleich 8 Zeichen ist
                                    if(strlen($_POST['passwort']) >= 8){
                                        //Suche in der Datenbank nach dem benutzernamen    
                                        $dbbenutzername = getUsernameByUsername($benutzername);;
    
                                        //Wenn es den Benutzernamen noch nicht gibt
                                        if ($dbbenutzername != $benutzername){
                                            //Wenn das Passwort beide male gleich ist
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
            //den neuen Benutzer in die Datenbank einfügen
            insertUser($benutzername, $_POST['passwort'], $name, $vorname);
            $userid = getUserIDByUsername($_POST['benutzername']);
            //eine Session für die Benutzerid machen
            $_SESSION['user_add'] = $userid;
            header('Location: user_group_add');
        }
        else{
            header('Location: user_add');
        }
    }      
    //Wenn Zurück geklickt wurde
    else if($_POST['submit_btn'] == "Zurück"){
        header('Location: user');
    }
    else{
        header('Location: home');
    }
?>