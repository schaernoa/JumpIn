<?php
    //Error Session leeren
    $_SESSION['error'] = NULL;
    //Validierungsvariable
    $invalid = false;
    //Variable für specialchars Validierung
    $name;

    //Wenn Ändern geklickt wurde
    if($_POST['submit_btn'] == "Ändern"){
        //Wenn alle Felder ausgefüllt wurden
        if(!empty($_POST['gruppenname']) & !empty($_POST['level'])){
            //den Namen specialchars validieren
            $name = htmlspecialchars($_POST['gruppenname']);
            //Wenn der name kleiner oder gleich 30 Zeichen ist
            if(strlen($name) <= 30){
                //Wenn das Level eine ganze Zahl ist
                if(ctype_digit($_POST['level'])){
                    //Den Datensatz der zu veränderenden Gruppe holen
                    $result = getGroupByID($_SESSION['id_gruppe']);
                
                    //Wenn der Name Anders als der vordere ist
                    if($result['name'] != $name){
                        //Suche in der Datenbank nach dem neuen Gruppennamen
                        $resultatstring = getGroupnameByGroupname($name);
                        //Wenn es diesen noch nicht gibt 
                        if ($resultatstring != $name){
                            //Eingaben richtig
                            $invalid = true;
                        }
                        else{
                            $_SESSION['error'] = "Gruppe mit diesem Gruppennamen existiert bereits!";
                        }
                    }
                    else{
                        $invalid = true;
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
        //Wenn Eingaben richtig
        if($invalid){
            //Den Datensatz dieser Gruppe ändern
            updateGroupByID($_SESSION['id_gruppe'], $name, $_POST['level']);
            header('Location: group_edit_choice');
        }
        else{
            header('Location: group_edit');
        }
    }   
    //Wenn Zurück geklickt wurde   
    else if($_POST['submit_btn'] == "Zurück"){
        header('Location: group_edit_choice');
    }
    else{
        header('Location: home');
    }
?>