<?php
    //error session leeren und die validierungsvariable setzen
    $_SESSION['error'] = NULL;
    $invalid = false;

    //wenn das feld anzahlteilnehmende ausgefüllt wurde
    if(!empty($_POST['anzahlteilnehmer'])){
        //wenn das feld anzahlteilnehmende eine zahl ist
        if(ctype_digit($_POST['anzahlteilnehmer'])){
            //wenn im select ein aktivitätsblock ausgewählt wurde
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
    //wenn alles richtig eingegeben wurde
    if($invalid){
        //wenn eine session variable gesetzt wurde
        if(isset($_SESSION['info'])){
            //aktivität mit info in der datenbank ändern
            updateActivity($_SESSION['id_aktivitaet'], $_SESSION['aktivitaetsname'], getActivityentityIDByName($_POST['aktivitaetblock']), getArtIDByName($_SESSION['aktivitaetsart']), $_SESSION['treffpunkt'], $_POST['anzahlteilnehmer'], validateDateTime($_SESSION['startdate'], $_SESSION['starttime']), validateDateTime($_SESSION['enddate'], $_SESSION['endtime']), $_SESSION['info']);
        }
        else{
            //aktivität ohne eine info in der datenbank ändern
            updateActivity($_SESSION['id_aktivitaet'], $_SESSION['aktivitaetsname'], getActivityentityIDByName($_POST['aktivitaetblock']), getArtIDByName($_SESSION['aktivitaetsart']), $_SESSION['treffpunkt'], $_POST['anzahlteilnehmer'], validateDateTime($_SESSION['startdate'], $_SESSION['starttime']), validateDateTime($_SESSION['enddate'], $_SESSION['endtime']), NULL);
        }
        //session info leeren
        unset($_SESSION["info"]);
        //weiterleiten nach aktivitaet_edit_group.php
        header('Location: aktivitaet_edit_group');
    }
    else{
        //weiterleiten nach aktivitaet_edit_group.php
        header('Location: aktivitaet_edit_einschreiben');
    }
?>