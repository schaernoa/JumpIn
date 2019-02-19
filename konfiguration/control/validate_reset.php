<?php
    //Error Session leeren
    $_SESSION['error'] = NULL;
    //Wenn Reset geklickt wurde
    if($_POST['submit_btn'] == "Reset"){
        //Jumpin zurücksetzen
        resetJumpin();
        //Ordnername festlegen
        $ordnername = "../app/userimages/";
        //überprüfen ob das Verzeichnis existiert
        if(is_dir($ordnername)) {
            //Ordner öffnen zur weiteren Bearbeitung
            if ($directory = opendir($ordnername)) {
                //Für jedes File im Verzeichnis
                while (($file = readdir($directory)) !== false) {
                    //Die Standardordner . und .. sollen ignoriert werden
                    if ($file!="." AND $file !="..") {
                        //Files vom Server entfernen
                        unlink("../app/userimages/$file");
                    }
                }
            //geöffnetes Verzeichnis wieder schließen
            closedir($directory);
            }
        }
        header('Location: allgemein');
    }      
    else if($_POST['submit_btn'] == "Zurück"){
        header('Location: allgemein');
    }
    else{
        header('Location: home');
    }
?>