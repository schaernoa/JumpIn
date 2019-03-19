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
                    $urlbild = $_POST['srcbild'];
                    if(!$urlbild == ""){

                        $uploaddir = getcwd()."/userimages/";
                        $uploaddir = trim($uploaddir);
                        $filename = getUserIDByUsername($_SESSION['benutzer_app']);
                        $fullfileName = $filename. ".png";
                        $fullpath = $uploaddir.$fullfileName;

                        $img = $urlbild;
                        $img = str_replace('data:image/png;base64,', '', $img);
                        $img = str_replace(' ', '+', $img);
                        $data = base64_decode($img);

                        file_put_contents($fullpath, $data);
                        if(file_exists($fullpath)){
                            $validated = true;
                        }
                        else{
                            $_SESSION['error'] = "Das Bild konnte nicht gespeichert werden!";
                        }
                    }
                    else{
                        $_SESSION['error'] = "Es muss ein Bild ausgewählt sein!";
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