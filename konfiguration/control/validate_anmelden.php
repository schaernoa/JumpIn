<?php
    //Error Session leeren
    $_SESSION['error'] = NULL;
    //Validierungsvariable
    $invalid = false;
    //Variablen für specialchars Validierung
    $benutzername;

    //Wenn Login geklickt wurde
    if($_POST['submit_btn'] == 'Login'){
        //Wenn alle Felder nicht leer sind
        if(!(empty($_POST['passwort'])) & !(empty($_POST['benutzername']))){
            //den Benutzernamen specialchars validieren
            $benutzername = htmlspecialchars($_POST['benutzername']);
            //das Passwort vom Benutzer holen
            $dbpasswort = getPasswordByUsername($benutzername);
            //Das passwort mit dem Salz vom benutzernamen verschlüsseln
            $usrpasswort = hash('sha256', $_POST['passwort'] . $benutzername);
            
            //Wenn das eingegebene Passwort mit dem der Datenbank übereinstimmt
            if($usrpasswort == $dbpasswort){
                //Alle gruppen vom Benutzer holen
                $gruppenabfrage = getGroupnameByUsername($benutzername);
                //Für alle Gruppen
                while ($gruppenabfragearray = mysqli_fetch_assoc($gruppenabfrage)) {
                    //Wenn der Benutzer in der Gruppe Admin ist
                    if(strtolower($gruppenabfragearray["gruppenname"]) == "admin"){
                        //Alle eingaben korrekt
                        $invalid = true;
                    }
                    else{
                        $_SESSION['error'] = "Dieser Benutzer verfügt nicht über genügend Berechtigung!";
                    }
                }
            }
            else{
                $_SESSION['error'] = "Benutzername und/oder Passwort sind nicht richtig!";
            }
        }
        else{
            $_SESSION['error'] = "Es wurden nicht alle Felder ausgefüllt!";
        }
        //Wenn alle Eingaben richtig sind
        if($invalid){
            //Eine Session auf den Benutzer setzen
            $_SESSION['benutzer'] = $benutzername;
            header('Location: home');
        }
        else{
            header('Location: login');
        }
    }
    else{
        header('Location: login');
    }
?>