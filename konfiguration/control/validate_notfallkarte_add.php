<?php
    //Error Session leeren
    $_SESSION['error'] = NULL;
    //Validierungsvariable
    $invalid = false;
    //Variabeln für die specialchars Validierung
    $name;
    $info;

    //Wenn Erstellen geklickt wurde
    if($_POST['submit_btn'] == "Erstellen"){
        //Wenn alle Felder nicht leer sind
        if(!empty($_POST['name']) & !empty($_POST['info'])){
            //name und info specialchars validieren
            $name = htmlspecialchars($_POST['name']);
            $info = htmlspecialchars($_POST['info']);
            //Wenn der name kürzer oder gleich 30 Zeichen ist
            if(strlen($name) <= 30){
                //Wenn die Info kürzer oder gleich 300 Zeichen lang ist
                if(strlen($info) <= 300){
                    //Eingaben richtig
                    $invalid = true;
                }
                else{
                    $_SESSION['error'] = "Die Notfallinfo ist zu lang! Max. 300 Zeichen!";
                }        
            }
            else{
                $_SESSION['error'] = "Der Notfallname ist zu lang! Max. 30 Zeichen!";
            }
        }
        else{
            $_SESSION['error'] = "Es wurden nicht alle Felder ausgefüllt!";
        }
        //enn Eingaben richtig
        if($invalid){
            //Die Notfallkategorie in die Datenbank einfügen
            insertEmergencyCategory($name, $info);
            header('Location: notfallkarte');
        }
        else{
            header('Location: notfallkarte_add');
        }
    }      
    //Wenn Zurück geklickt wurde
    else if($_POST['submit_btn'] == "Zurück"){
        header('Location: notfallkarte');
    }
    else{
        header('Location: home');
    }
?>