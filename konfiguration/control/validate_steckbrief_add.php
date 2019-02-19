<?php
    //Error Session leeren
    $_SESSION['error'] = NULL;
    //Validierungsvariable setzen
    $invalid = false;
    $obligation = 0;
    $einzeiler = 0;
    //Variable für die specialchars Validierung
    $name;

    //Wenn Erstellen geklickt wurde
    if($_POST['submit_btn'] == "Erstellen"){
        //Wenn alle Felder nicht leer sind
        if(!empty($_POST['name']) & !empty($_POST['obligation']) & !empty($_POST['einzeiler'])){
            //den Namen specialchars validieren
            $name = htmlspecialchars($_POST['name']);
            //Wenn der Name kürzer oder gleich 30 Zeichen ist
            if(strlen($name) <= 30){
                //Eingaben richtig             
                $invalid = true;
                //Wenn diese Steckbriefkategorie Obligatorisch ist
                if($_POST['obligation'] == "true"){
                    $obligation = 1;
                }
                //Wenn diese Steckbriefkategore eine Einzeilige Antwort hat
                if($_POST['einzeiler'] == "true"){
                    $einzeiler = 1;
                }
            } 
            else{
                $_SESSION['error'] = "Der Steckbriefkategoriename ist zu lang! Max. 30 Zeichen!";
            }
        }
        else{
            $_SESSION['error'] = "Es wurden nicht alle Felder ausgefüllt!";
        }
        //Wenn Eingaben richtig
        if($invalid){
            //Steckbriefkategorie hinzufügen
            insertCharacteristicsCategory($name, $obligation, $einzeiler);
            header('Location: steckbrief');
        }
        else{
            header('Location: steckbrief_add');
        }
    }      
    //Wenn Zurück geklickt wurde
    else if($_POST['submit_btn'] == "Zurück"){
        header('Location: steckbrief');
    }
?>