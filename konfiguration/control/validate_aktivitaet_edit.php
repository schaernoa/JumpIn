<?php
    //error session leeren und zwei validierungsvariablen setzen
    $_SESSION['error'] = NULL;
    $invalid = false;
    $einschreiben = false;
    //variablen für htmlspecialchars validierte felder
    $aktivitaetsname;
    $treffpunkt;

    //wenn der knopf Weiter gedrückt wurde
    if($_POST['submit_btn'] == "Weiter"){
        //wenn alle obligatorischen felder ausgefüllt wurden
        if(!empty($_POST['aktivitaetsname']) & !empty($_POST['treffpunkt']) & !empty($_POST['startdate']) & !empty($_POST['starttime']) & !empty($_POST['enddate']) & !empty($_POST['endtime'])){
            //spezielle zeichen aus den eingaben escapen
            $aktivitaetsname = htmlspecialchars($_POST['aktivitaetsname']);
            $treffpunkt = htmlspecialchars($_POST['treffpunkt']);
            //wenn der aktivitätsname höchstens 30 Zeichen lang ist
            if(strlen($aktivitaetsname) <= 30){
                //wenn der treffpunkt höchstens 30 Zeichen lang ist
                if(strlen($treffpunkt) <= 30){
                    //wenn im select eine aktivitätsart ausgewählt wurde
                    if($_POST['aktivitaetsart'] != "null"){
                        //validierungsvariable auf richtig setzen
                        $invalid = true;
                        //spezielle zeichen von Info escapen
                        $info = htmlspecialchars($_POST['info']);
                        if(!empty($_POST['info'])){
                            //wenn die info höchstens 500 zeichen lang ist
                            if(strlen($info) <= 500){
                                //session info setzen
                                $_SESSION['info'] = $info;
                            }
                            else{
                                //error session setzen
                                $_SESSION['error'] = "Die Info ist zu lang! Max. 500 Zeichen!";
                            }
                        }
                        else{
                            $_SESSION['info'] = NULL;
                        }
                        //wenn die aktivitätsart zum einschreiben ist
                        $resultarray = getArtByName($_POST['aktivitaetsart']);
                        if($resultarray['einschreiben'] == "1"){
                            //einschreiben auf richtig setzen
                            $einschreiben = true;
                        }
                    }
                    else{
                        //error session setzen
                        $_SESSION['error'] = "Es wurde keine Aktivitätsart ausgewählt!";
                    }
                }
                else{
                    //error session setzen
                    $_SESSION['error'] = "Der Treffpunkt ist zu lang! Max. 30 Zeichen!";
                }
            }
            else{
                //error session setzen
                $_SESSION['error'] = "Der Aktivitätsname ist zu lang! Max. 30 Zeichen!";
            }
        }
        else{
            //error session setzen
            $_SESSION['error'] = "Es wurden nicht alle Felder ausgefüllt!";
        }
        //wenn alles richtig eingegeben wurde
        if($invalid){
            //wenn die aktivität zum einschreiben ist
            if($einschreiben == true){
                //setze die daten in sessions um erst später in datenbank zu inserten
                $_SESSION['aktivitaetsname'] = $aktivitaetsname;
                $_SESSION['aktivitaetsart'] = $_POST['aktivitaetsart'];
                $_SESSION['treffpunkt'] = $treffpunkt;
                $_SESSION['startdate'] = $_POST['startdate'];
                $_SESSION['starttime'] = $_POST['starttime'];
                $_SESSION['enddate'] = $_POST['enddate'];
                $_SESSION['endtime'] = $_POST['endtime'];
                //weiterleiten nach aktivitaet_add_einschreiben.php
                header('Location: aktivitaet_edit_einschreiben');
            }
            else{
                //wenn eine info gesetz wurde
                if(isset($_SESSION['info'])){
                    //aktivität mit info in datenbank inserten
                    updateActivity($_SESSION['id_aktivitaet'], $aktivitaetsname, NULL, getArtIDByName($_POST['aktivitaetsart']), $treffpunkt, NULL, validateDateTime($_POST['startdate'], $_POST['starttime']), validateDateTime($_POST['enddate'], $_POST['endtime']), $_SESSION['info']);
                }
                else{
                    //aktivität ohne info in datenbank inserten
                    updateActivity($_SESSION['id_aktivitaet'], $aktivitaetsname, NULL, getArtIDByName($_POST['aktivitaetsart']), $treffpunkt, NULL, validateDateTime($_POST['startdate'], $_POST['starttime']), validateDateTime($_POST['enddate'], $_POST['endtime']), NULL);
                }
                //weiterleiten nach aktivitaet_add_group.php
                header('Location: aktivitaet_edit_group');
            }
        }
        else{
            //weiterleiten nach aktivitaet_edit.php
            header('Location: aktivitaet_edit');
        }
    }
    //Wenn der knopf Zurück gedrückt wurde
    if($_POST['submit_btn'] == "Zurück"){
        //weiterleiten nach aktivitaet.php
        header('Location: aktivitaet_edit_choice');
    }
?>