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
                $validation = true;
                $x++;
                if(!empty($_POST[''.$validate.''])){
                    $steckbrief = htmlspecialchars($_POST[''.$validate.'']);
                    //Alter validieren --> muss Zahl sein
                    if($validate == "3"){
                        if(!is_numeric($steckbrief)){
                            $kat .= "(Alter) ";
                            $validation = false;
                        }
                    }
                    //Mehrzeiler validieren --> Max 5 Zeilen
                    if($_POST[''.$validate.'_1'] == "mehrzeiler"){
                        $lines_arr = preg_split('/\n/',$steckbrief);
                        $num_newlines = count($lines_arr); 
                        if($num_newlines > 5){
                            $validation = false;
                        }
                    }
                    //Wenn länge und Validierung ok sind
                    if(strlen($steckbrief) <= 300 && $validation){
                        $y++;
                    }
                }
            }
            //Wenn jede Kategorie ausgefüllt wurde
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
                    if(!file_exists($fullpath)){
                        $_SESSION['error'] = "Das Bild konnte nicht gespeichert werden!";
                    }
                }
                else{
                    $validated = true;
                }
            }
            else{
                $_SESSION['error'] = "Nicht alle Kategorien $kat im Steckbrief wurden richtig ausgefüllt! (Max. 5 Zeilen pro Feld)";
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
        }
        header('Location: steckbrief_view');
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
            removesessioninvalid(array("steckbrief"));
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

    function imageResize($imageResourceId,$width,$height) {


        $targetWidth=200;
        $targetHeight=200;
    
    
        $targetLayer=imagecreatebackground($targetWidth,$targetHeight);
        imagecopyresampled($targetLayer,$imageResourceId,0,0,0,0,$targetWidth,$targetHeight, $width,$height);
    
    
        return $targetLayer;
    }
?>