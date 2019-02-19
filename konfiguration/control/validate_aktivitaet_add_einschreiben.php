<?php
    //error session leeren und die validierungsvariable setzen
    $_SESSION['error'] = NULL;
    $invalid = false;

    //wenn das feld anzahlteilnehmer ausgefüllt wurde
    if(!empty($_POST['anzahlteilnehmer'])){
        //wenn das feld anzahlteilnehmer eine ganze zahl ist
        if(ctype_digit($_POST['anzahlteilnehmer'])){
            //wenn beim select aktivitätsblock ein aktivitätsblock ausgewählt wurde
            if($_POST['aktivitaetblock'] != "null"){
                //validierungsvariable auf richtig setzen
                $invalid = true;  
            }
            else{
                //error session setzen
                $_SESSION['error'] = "Es wurde kein Aktivitätsblock ausgewählt!";
            }
        }
        else{
            //error session setzen
            $_SESSION['error'] = "Anzahlteilnehmer muss eine Zahl sein!";
        }
    }
    else{
        //error session setzen
        $_SESSION['error'] = "Es wurden nicht alle Felder ausgefüllt!";
    }
    //wenn alle eingaben richtig validiert wurden
    if($invalid){
        //wenn die session info gesetz wurde
        if(isset($_SESSION['info'])){
            //aktivität mit info in datenbank inserten
            insertActivity($_SESSION['aktivitaetsname'], getActivityentityIDByName($_POST['aktivitaetblock']), getArtIDByName($_SESSION['aktivitaetsart']), $_SESSION['treffpunkt'], $_POST['anzahlteilnehmer'], validateDateTime($_SESSION['startdate'], $_SESSION['starttime']), validateDateTime($_SESSION['enddate'], $_SESSION['endtime']), $_SESSION['info']);
        }
        else{
            //aktivität ohne info in datenbank inserten
            insertActivity($_SESSION['aktivitaetsname'], getActivityentityIDByName($_POST['aktivitaetblock']), getArtIDByName($_SESSION['aktivitaetsart']), $_SESSION['treffpunkt'], $_POST['anzahlteilnehmer'], validateDateTime($_SESSION['startdate'], $_SESSION['starttime']), validateDateTime($_SESSION['enddate'], $_SESSION['endtime']), NULL);
        }
        //session info leeren
        unset($_SESSION["info"]);
        //weiterleiten nach aktivitaet_add_group.php
        header('Location: aktivitaet_add_group');
    }
    else{
        //weiterleiten nach aktivitaet_add_einschreiben.php
        header('Location: aktivitaet_add_einschreiben');
    }
?>