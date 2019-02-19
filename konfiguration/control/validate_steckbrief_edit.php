<?php
    //Error Session leeren
    $_SESSION['error'] = NULL;
    //Validierungsvariable
    $invalid = false;
    $obligation = 0;
    $einzeiler = 0;
    //Variable für die specialchars Validierung
    $name;

    //Wenn Ändern geklickt wurde
    if($_POST['submit_btn'] == "Ändern"){
        //Wenn alle Felder nicht leer sind
        if(!empty($_POST['name']) & !empty($_POST['obligation']) & !empty($_POST['einzeiler'])){
            //den namen specialchars validieren
            $name = htmlspecialchars($_POST['name']);
            //Wenn der Name kürzer oder gleich 30 Zeichen ist
            if(strlen($name) <= 30){     
                //Eingaben richtig         
                $invalid = true;
                //Wenn es eine Obligatorische Steckbriefkategorie ist
                if($_POST['obligation'] == "true"){
                    $obligation = 1;
                }
                //Wenn die Antwort auf diese Steckbriefkategorie Einzeilig ist
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
            //Steckbriefkategorie ändern
            updateCharacteristicsCategory($_SESSION['id_steckbriefkategorie'], $name, $obligation, $einzeiler);
            header('Location: steckbrief');
        }
        else{
            header('Location: steckbrief_edit');
        }
    }      
    //Wenn Zurück geklickt wurde
    else if($_POST['submit_btn'] == "Zurück"){
        header('Location: steckbrief_edit_choice');
    }
    else{
        header('Location: home');
    }
?>