<?php 
    //Uploaded File
    $csv_file =  $_FILES['csv_file']['tmp_name'];
    //DB Einträge Variablen
    $counter = 0;
    $error = 0;
    //Passwort Variable
    global $pass, $invalidUsernames;
    $pass = array();
    $invalidUsernames = array();

    if(is_file($csv_file)) {
        //Upload File öffnen
        $input = fopen($csv_file, 'a+');
        //Spaltentitel entfernen (Wenn keine Titel vorhanden --> Zeile auskommentieren)
        $row = fgetcsv($input, 1024, ';');
        //Logfiles instanzieren
        $logfile = './log/import_log.txt';
        $usersfile = './log/newusers_log.txt';

        //Logfiles wenn noch nicht vorhanden erstellen, Titel / Trennlinie einschreiben
        if(!is_file($logfile)){
            $title = "Logs\n\n";
            file_put_contents($logfile, $title);
        }
        else{
            file_put_contents($logfile, "\n--------------------------------------------------------------------\n".PHP_EOL , FILE_APPEND | LOCK_EX);
        }
        if(!is_file($usersfile)){
            $title = "All new Users\n\n";
            file_put_contents($usersfile, $title);
        }
        else{
            file_put_contents($usersfile, "\n-----------------------------------------\n".PHP_EOL , FILE_APPEND | LOCK_EX);
        }

        //Für alle Spaleten (ausser Titel - Z.18)
        while($row = fgetcsv($input, 1024, ';')) {
            //Damit die Umlaute richtig in die DB geschrieben werden.
            $row = array_map("utf8_encode", $row);
            //Attribute Auslesen und in Variable speichern
            $username = htmlspecialchars($row[0]);
            $password = $row[1];
            $name = htmlspecialchars($row[2]);
            $prename = htmlspecialchars($row[3]);
            $groups = $row[4];
            //Mit Komma getrennete Gruppen aufspalten und in separates Array speichern
            $groupArray = explode(', ', $groups);

            //Variablen für Logeinträge löschen
            $txt_user = '';
            $txt_group = '';

            //Wenn Passwortfeld leer ist (Oder nur ein Leerschlag beinhaltet)
            if($password == "" || $password == " "){
                $password = generatePassword();
            }

            //Prüfung der Attribute
            //Wenn der Benutzername kleiner oder gleich 30 Zeichen ist
            if(strlen($username) <= 30 && strlen($username) != 0){
                //Wenn der Vorname kleiner oder gleich 50 Zeichen ist
                if(strlen($prename) <= 50 && strlen($prename) != 0){
                    //Wenn der name kleiner oder gleich 50 Zeichen ist
                    if(strlen($name) <= 50 && strlen($name) != 0){
                        //Wenn es ein Kleinbuchstaben im passwort hat
                        if(preg_match('/[a-z]/', $password)){
                            //Wenn es einen Grossbuchstaben im Passwort hat
                            if(preg_match('/[A-Z]/', $password)){
                                //Wenn es eine ziffer im Passwort hat
                                if(preg_match('/\d/', $password)){
                                    //Wenn das Passwort länger oder gleich 8 Zeichen ist
                                    if(strlen($password) >= 8){
                                        $dbbenutzername = getUsernameByUsername($username);
                                        //Wenn es den Benutzernamen noch nicht gibt
                                        if ($dbbenutzername != $username){
                                            //Benutzer in DB speichern
                                            insertUser($username, $password, $name, $prename);
                                            //Text für Logfile setzen
                                            $txt_user = "$prename $name: $username - $password";
                                            file_put_contents($usersfile, $txt_user.PHP_EOL , FILE_APPEND | LOCK_EX);
                                            $counter++;
                                            //Wenn mindestens eine Gruppe mitgegeben wurde
                                            if(count($groupArray) != Null){
                                                //Userid aus DB lesen
                                                $userid = (int)getUserIDByUsername($username);
                                                //Über das Gruppen-Array iterieren
                                                foreach($groupArray as $group){
                                                    $groupid = (int)getGroupIDByName($group);
                                                    //Wenn die Gruppe mit dem Mitgegebenen Namen Existiert
                                                    if($groupid != null){
                                                        //In Benutzer_Gruppe speichern
                                                        insertUserGroup($groupid, $userid);
                                                        //Log-Eintrag machen
                                                        $txt_group = "$username in $group";
                                                        file_put_contents($logfile, $txt_group.PHP_EOL , FILE_APPEND | LOCK_EX);
                                                    }
                                                    else{
                                                        //Fehler in Log-File schreiben
                                                        $txt_group = "Error: no groupID in DB for group: $group";
                                                        file_put_contents($logfile, $txt_group.PHP_EOL , FILE_APPEND | LOCK_EX);
                                                    }
                                                }
                                            }
                                            else{
                                                //Warning in Log-File schreiben
                                                $txt_group = "Warning: no groups given for user: $username - Add groups for User in /konfiguration/user_group_edit/";
                                                file_put_contents($logfile, $txt_group.PHP_EOL , FILE_APPEND | LOCK_EX);
                                            }
                                        }
                                        else{
                                            array_push($invalidUsernames, $username);
                                            //Fehler in Log-File schreiben
                                            $txt_user = "Error: Username already exists: $prename $name: $username - $password";
                                            $error++;
                                            file_put_contents($logfile, $txt_user.PHP_EOL , FILE_APPEND | LOCK_EX);
                                        }
                                    }
                                    else{
                                        //Fehler in Log-File schreiben
                                        $txt_user = "Error: (Password) $prename $name: $username - $password";
                                        $error++;
                                        file_put_contents($logfile, $txt_user.PHP_EOL , FILE_APPEND | LOCK_EX);
                                    }
                                }
                                else{
                                    //Fehler in Log-File schreiben
                                    $txt_user = "Error: (Password) $prename $name: $username - $password";
                                    $error++;
                                    file_put_contents($logfile, $txt_user.PHP_EOL , FILE_APPEND | LOCK_EX);
                                }
                            }
                            else{
                                //Fehler in Log-File schreiben
                                $txt_user = "Error: (Password) $prename $name: $username - $password";
                                $error++;
                                file_put_contents($logfile, $txt_user.PHP_EOL , FILE_APPEND | LOCK_EX);
                            }
                        }
                        else{
                            //Fehler in Log-File schreiben
                            $txt_user = "Error: (Password) $prename $name: $username - $password";
                            $error++;
                            file_put_contents($logfile, $txt_user.PHP_EOL , FILE_APPEND | LOCK_EX);
                        }
                    }
                    else{
                        //Fehler in Log-File schreiben
                        $txt_user = 'Error: (Name) '.$prename.' '.$row[1].': '.$username.' - '.$password.'';
                        $error++;
                        file_put_contents($logfile, $txt_user.PHP_EOL , FILE_APPEND | LOCK_EX);
                    }
                }
                else{
                    //Fehler in Log-File schreiben
                    $txt_user = "Error: (Prename) $prename $name: $username - $password";
                    $error++;
                    file_put_contents($logfile, $txt_user.PHP_EOL , FILE_APPEND | LOCK_EX);
                }        
            }
            else{
                //Fehler in Log-File schreiben
                $txt_user = "Error: (Username) $prename $name: $username - $password";
                $error++;
                file_put_contents($logfile, $txt_user.PHP_EOL , FILE_APPEND | LOCK_EX);
            }
        }
        $_SESSION['success_user_import'] = $counter;
        $_SESSION['error_user_import'] = $error;
        $_SESSION['invalid_usernames'] = $invalidUsernames;
        $_SESSION['no_file'] = 0;
        header('Location: user_import_result');

    }
    else{
        if($_SESSION['url'] != "show_results"){
            $_SESSION['no_file'] = 1;
        }
        header('Location: user');
    }

    function generatePassword(){
        //Variable zum kontrollieren, ob Gross-/Kleinschreibung und Zahl verwendet wurde
        $usedArrays = array();
        $klein = 'abcdefghijklmnopqrstuvwxyz';
        $gross = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $zahl = '1234567890';
        $kleinLength = strlen($klein) - 1;
        $grossLength = strlen($gross) - 1;
        $zahlLength = strlen($zahl) - 1;

        //8 Zeichen definieren
        for ($i = 0; $i < 8; $i++) {
            //Array zufällig auswählen
            $arr = rand(0, 2);
            //Nach der 6. Iteration schauen, ob alle Arrays bereits genutzt wurden
            if($i > 6){
                if(count($usedArrays) != 3){
                    if(!in_array(0, $usedArrays)){
                        $arr = 0;
                    }
                    else if(!in_array(1, $usedArrays)){
                        $arr = 1;
                    }
                    else if(!in_array(2, $usedArrays)){
                        $arr = 2;
                    }
                }
            }
            //Für das ausgewählte Array ein zufälliges Element auswählen und in Passwort-Array speichern
            switch($arr){
                case 0:
                    $n = rand(0, $kleinLength);
                    $pass[] = $klein[$n];
                    break;
                case 1:
                    $n = rand(0, $grossLength);
                    $pass[] = $gross[$n];
                    break;
                case 2:
                    $n = rand(0, $zahlLength);
                    $pass[] = $zahl[$n];
                    break;
            }
            //genutztes Array in usedArrays speichern wenn noch nicht vorhanden
            if(!in_array($arr, $usedArrays)){
                array_push($usedArrays, $arr);
            }
        }
        //Passwort Array in String umwandeln und zurückgeben
        return implode($pass);
    }
?>