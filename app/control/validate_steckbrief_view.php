<?php
    //Fehlermeldung löschen
    $_SESSION['error'] = NULL;
    $validated = false;
    $bild = false;

    //Wenn der Knopf Ändern geklickt wurde
    if($_POST['submit_btn'] == "Ändern"){
        if(!empty($_POST['steckbrief'])){
            $x = 0;
            $y = 0;
            foreach($_POST['steckbrief'] as $validate){
                $x++;
                if(!empty($_POST[''.$validate.''])){
                    $steckbrief = htmlspecialchars($_POST[''.$validate.'']);
                    if(strlen($steckbrief) <= 300){
                        $y++;
                    }
                }
            }
            //Wenn jede Kategorie ausgefüllt wurde
            if($x == $y){
                //Wenn ein File angegeben wurde
                if(!$_FILES['bild']['name'] == ""){
                    $allowed =  array('jpeg','png','jpg');
                    $filename = $_FILES['bild']['name'];
                    $extension = pathinfo($filename, PATHINFO_EXTENSION);
                    //Wenn die Dateiendung erlaubt ist
                    if(in_array(strtolower($extension),$allowed)) {
                        //Wenn Bild < als 8MB
                        if(filesize($_FILES['bild']['tmp_name']) < 8388608){
                            $uploaddir = getcwd()."/userimages/ ";
                            $uploaddir = trim($uploaddir);
                            $filename = getUserIDByUsername($_SESSION['benutzer_app']);
                            $uploadfile = $uploaddir.$filename.".png";
                            move_uploaded_file($_FILES['bild']['tmp_name'], $uploadfile);
                            $validated = true;
                        }
                        else{
                            $_SESSION['error'] = "Zu grosses Bild eingelesen!";
                        }
                    }
                    else{
                        $_SESSION['error'] = "Das eingelesene File ist kein Bild!";
                    }
                }
                else{
                    $validated = true;
                }
            }
            else{
                $_SESSION['error'] = "Nicht alle Kategorien im Steckbrief wurden richtig ausgefüllt!";
            }
        }
        //Wenn richtig validiert
        if($validated){
            $userid = getUserIDByUsername($_SESSION['benutzer_app']);
            //Für jede Kategorie
            foreach($_POST['steckbrief'] as $validate){
                $steckbrief = htmlspecialchars($_POST[''.$validate.'']);
                //in der Datenbank den Datensatz ändern
                updateCharacteristics($validate, $userid, $steckbrief);
            }
            header('Location: steckbrief_view');
        }
        else{
            header('Location: steckbrief_view');
        }
    }
    else if($_POST['submit_btn'] == "Kategorie hinzufügen"){
        header('Location: steckbrief_kategorie_add');
    }
    else if($_POST['submit_btn'] == "Zurück"){
        //herausfinden wo man zurückgeschickt wird
        if(isset($_POST['mode'])){
            $_SESSION['mode'] = $_POST['mode'];
        }
        if($_SESSION['mode'] == "steckbrief"){
            header('Location: steckbrief');
        }
        else if($_SESSION['mode'] == "wochenplan") {
            header('Location: wochenplan_view');
        }
        else if($_SESSION['mode'] == "einschreiben"){
            header('Location: einschreiben');
        }
        else{
            header('Location: home');
        }
    }
    else{
        header('Location: home');
    }
?>