<?php
    //Fehlermeldung löschen
    $_SESSION['error'] = NULL;
    $validated = false;

    //Wenn der Knopf Erstellen geklickt wurde
    if($_POST['submit_btn'] == "Erstellen"){
        //Wenn ein File angegeben wurde
        if(!$_FILES['bild']['name'] == ""){
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
                //Wenn alle Kategorien ausgefüllt wurden
                if($x == $y){
                    $allowed =  array('jpeg','png','jpg');
                    $filename = $_FILES['bild']['name'];
                    $extension = pathinfo($filename, PATHINFO_EXTENSION);
                    //Wenn die File-Endung erlaubt ist
                    if(in_array(strtolower($extension),$allowed)) {
                        //Wenn das Bild kleiner ist als 8MB
                        if(filesize($_FILES['bild']['tmp_name']) < 8388608){
                            $uploaddir = getcwd()."/userimages/ ";
                            $uploaddir = trim($uploaddir);
                            $filename = getUserIDByUsername($_SESSION['benutzer_app']);
                            //pfad zum speichern festlegen
                            $uploadfile = $uploaddir.$filename.".png";
                            //das Bild verschieben und benennen
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
                    $_SESSION['error'] = "Nicht alle Kategorien im Steckbrief wurden richtig ausgefüllt!";
                }
            }
            else{
                $_SESSION['error'] = "Es wurden keine Kategorien im Steckbrief ausgefüllt!";
            }
        }
        else{
            $_SESSION['error'] = "Es wurde kein Bild angegeben!";
        }
        //wenn richtig validiert
        if($validated){
            $userid = getUserIDByUsername($_SESSION['benutzer_app']);
            //für jede ausgefüllte kategorie
            foreach($_POST['steckbrief'] as $validate){
                $steckbrief = htmlspecialchars($_POST[''.$validate.'']);
                //in datenbank einfügen
                insertCharacteristics($validate, $userid, $steckbrief);
            }
            $array = array("steckbrief_kategorie_add", "validate_steckbrief_kategorie_add");
            removeSessionInvalid($array);
            $array2 = array("steckbrief_add", "validate_steckbrief_add", "steckbrief", "steckbrief_view", "validate_steckbrief_order", "validate_steckbrief_loeschen");
            addSessionInvalid($array2);
            header('Location: steckbrief_kategorie_add');
        }
        else{
            header('Location: steckbrief_add');
        }
    }
    else if($_POST['submit_btn'] == "Zurück"){
        header('Location: home');
    }
    else{
        header('Location: home');
    }
?>