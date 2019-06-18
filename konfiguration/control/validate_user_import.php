<?php 
    //Uploaded File
    $csv_file = $_FILES['csv_file']['tmp_name'];
    //Passwort Variable
    global $pass, $invalidUsernames, $allNewUsers, $counter;
    $pass = array();
    $invalidUsernames = array();
    $allNewUsers = array();
    main($csv_file);

    function main($csv_file){
        if($_SESSION['users_added'] != 'done'){
            global $pass, $invalidUsernames, $counter;
            if(is_file($csv_file)){
                //DB Einträge Variablen
                $counter = 0;
                $error = 0;
                //Upload File öffnen
                $input = fopen($csv_file, 'a+');
                //Spaltentitel entfernen (Wenn keine Titel vorhanden --> Zeile auskommentieren)
                $row = fgetcsv($input, 1024, ';');
                //Logfiles instanzieren
                $logfile = '../../.././jumpin_log/import_log.txt';
                $usersfile = '../../.././jumpin_log/newusers_log.txt';
        
                prepareLogfiles($logfile, $usersfile);
        
                //Für alle Spaleten (ausser Titel - Z.18)
                while($row = fgetcsv($input, 1024, ';')){
                    //Damit die Umlaute richtig in die DB geschrieben werden.
                    $row = array_map("utf8_encode", $row);
                    //Attribute Auslesen und in Variable speichern
                    $username = htmlspecialchars(strtolower($row[0]));
                    $password = $row[1];
                    $name = htmlspecialchars($row[2]);
                    $prename = htmlspecialchars($row[3]);
                    $groups = $row[4];
                    //Mit Komma getrennete Gruppen aufspalten und in separates Array speichern
                    $groupArray = explode(', ', $groups);
                    //Variablen für Logeinträge löschen
                    $txt_user = '';
                    $txt_group = '';
        
                    $password = setPasswordIfNotSet($password);
        
                    $counters = validateInputs($username, $prename, $name, $password, $groupArray, $usersfile, $logfile, $counter, $error);
                    $counter = $counters[0];
                    $error = $counters[1];
                }
                setSessions($counter, $error, $invalidUsernames);
            }
            else{
                $counter = -1;
                $_SESSION['no_file'] = 'true';
            }
        }
        else{
            $counter = -1;
            $_SESSION['no_file'] = NULL;
        }
    }

    function prepareLogfiles($logfile, $usersfile){
        global $allNewUsers;
        //Logfiles wenn noch nicht vorhanden erstellen, Titel / Trennlinie einschreiben
        if(!is_file($logfile)){
            $title = "Logs\n\n";
            file_put_contents($logfile, $title);
        }
        else{
            file_put_contents($logfile, "\n-----------------------------------------\n".PHP_EOL , FILE_APPEND | LOCK_EX);
        }
        if(!is_file($usersfile)){
            $title = "All new Users\n\n";
            file_put_contents($usersfile, $title);
        }
        else{
            file_put_contents($usersfile, "\n-----------------------------------------\n".PHP_EOL , FILE_APPEND | LOCK_EX);
        }
        array_push($allNewUsers, ["Vorname", "Name", "Benutzername", "Passwort"]);
    }

    function setPasswordIfNotSet($password){
        //Wenn Passwortfeld leer ist (Oder nur ein Leerschlag beinhaltet)
        if($password == "" || $password == " "){
            $password = generatePassword();
        }
        return $password;
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
            $arr = chooseRandomArray($usedArrays, $i);
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

    function chooseRandomArray($usedArrays, $i){
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
        return $arr;
    }

    function validateInputs($username, $prename, $name, $password, $groupArray, $usersfile, $logfile, $counter, $error){
        global $invalidUsernames, $allNewUsers;
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
                                        array_push($allNewUsers, [$prename, $name, $username, $password]);
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
                                    $error = logErrors("Password", $logfile, $prename, $name, $username, $password, $error);
                                }
                            }
                            else{
                                $error = logErrors("Password", $logfile, $prename, $name, $username, $password, $error);
                            }
                        }
                        else{
                            $error = logErrors("Password", $logfile, $prename, $name, $username, $password, $error);
                        }
                    }
                    else{
                        $error = logErrors("Password", $logfile, $prename, $name, $username, $password, $error);
                    }
                }
                else{
                    $error = logErrors("Name", $logfile, $prename, $name, $username, $password, $error);
                }
            }
            else{
                $error = logErrors("Prename", $logfile, $prename, $name, $username, $password, $error);
            }        
        }
        else{
            $error = logErrors("Username", $logfile, $prename, $name, $username, $password, $error);
        }
        return array($counter, $error);
    }

    function logErrors($source, $logfile, $prename, $name, $username, $password, $error){
        //Fehler in Log-File schreiben
        $txt_user = "Error: ($source) $prename $name: $username - $password";
        file_put_contents($logfile, $txt_user.PHP_EOL , FILE_APPEND | LOCK_EX);
        $error++;
        return $error;
    }

    function setSessions($counter, $error, $invalidUsernames){
        $_SESSION['success_user_import'] = $counter;
        $_SESSION['error_user_import'] = $error;
        $_SESSION['invalid_usernames'] = $invalidUsernames;
        $_SESSION['no_file'] = NULL;
    }
?>

<script>
    <?php
        global $counter;
        if($_SESSION['users_added'] != 'done'){
            if($counter > 0){
    ?>
                writeToExcel();
    <?php
            }
            else if ($counter == 0){
                header('Location: user_import_result');
            }
            else{
                header('Location: user');
            }
        }
        else{
            header('Location: stack');
        }
    ?>

    function writeToExcel(){
        var result_table = <?php echo json_encode($allNewUsers); ?>;
        
        var lineArray = [];
        result_table.forEach(function(infoArray, index) {
            var line = infoArray.join("\t");
            lineArray.push(index == 0 ? line : line);
        });
        var csvContent = lineArray.join("\r\n");
        var excel_file = document.createElement('a');
        excel_file.setAttribute('href', 'data:application/vnd.ms-excel;charset=utf-8,' + encodeURIComponent(csvContent));
        excel_file.setAttribute('download', 'jumpin_newusers.xls');
        document.body.appendChild(excel_file);
        excel_file.click();
        document.body.removeChild(excel_file);

        createHtmlElements();
    }

    function createHtmlElements(){

        var h1 = document.createElement("p");
        var text = document.createTextNode("Bitte das Dokument speichern, bevor <Weiter> gedrückt wird...");     // Create a text node
        h1.appendChild(text); 
        h1.setAttribute('class', 'p_form_title');

        document.body.appendChild(h1);

        var form1 = document.createElement("form");
        var input1 = document.createElement("input");

        form1.method = "POST";
        form1.action = "user_import_result";   

        input1.value = "Weiter";
        input1.type = "submit";
        input1.setAttribute('class', 'button_weiter_import');
        form1.appendChild(input1);

        document.body.appendChild(form1);
    }
</script>