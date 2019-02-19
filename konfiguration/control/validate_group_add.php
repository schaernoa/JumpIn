<?php
    //Error Session leeren
    $_SESSION['error'] = NULL;
    //Validierungsvariable
    $invalid = false;
    //Variable für specialchars Validierung
    $name;

    //Wenn Erstellen geklickt wurde
    if($_POST['submit_btn'] == "Erstellen"){
        //Wenn alle Felder nicht leer sind
        if(!empty($_POST['gruppenname']) & !empty($_POST['level'])){
            //Den Namen specialchars validieren
            $name = htmlspecialchars($_POST['gruppenname']);
            //Wenn der Name kürzer oder gleich 30 Zeichen ist
            if(strlen($name) <= 30){
                //Wenn Level eine Ganze Zahl ist
                if(ctype_digit($_POST['level'])){
                    //Suche in der Datenbank nach dem Gruppenanmen
                    $dbgroupname = getGroupnameByGroupname($name);
    
                    //Wenn es noch keine Gruppe mit diesem Namen gibt
                    if ($dbgroupname != $name){
                        //Eingaben richtig
                        $invalid = true;
                    }
                    else{
                        $_SESSION['error'] = "Gruppe mit diesem Gruppennamen existiert bereits!";
                    }
                }   
                else{
                    $_SESSION['error'] = "Level muss eine Zahl sein!";
                }         
            }
            else{
                $_SESSION['error'] = "Der Gruppenname ist zu lang! Max. 30 Zeichen!";
            } 
        }
        else{
            $_SESSION['error'] = "Es wurden nicht alle Felder ausgefüllt!";
        }
        //Wenn alle Eingaben valid sind
        if($invalid){
            //Gruppe in Datenbank einfügen
            insertGroup($name, $_POST['level']);
            header('Location: group');
        }
        else{
            header('Location: group_add');
        }
    }      
    //Wenn Zurück geklickt wurde
    else if($_POST['submit_btn'] == "Zurück"){
        header('Location: group');
    }
    else{
        header('Location: home');
    }
?>