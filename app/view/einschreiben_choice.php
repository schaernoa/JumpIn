<?php
    //Error Session leeren
    $_SESSION['error'] = NULL;
    $id;
    //Hole die richtige AktivitätsartID. Entweder aus Session oder aus Post
    if(empty($_POST['id_aktivitaetsart'])){
        $id = intval($_SESSION['id_aktivitaetsart']);
        $_SESSION['id_aktivitaetsart'] = $id;
    }
    else{
        $id = $_POST['id_aktivitaetsart'];
        $_SESSION['id_aktivitaetsart'] = $id;
    }
    if(!empty($id)){
        $counter = 0;
        $activityentities = getActivityentityByArtID($id);
        while($row1 = mysqli_fetch_assoc($activityentities)){
            //Wenn der jetzige Zeitpunkt nach der Einschreibezeit des Aktivitätblockes ist
            if(strtotime(date("Y-m-d H:i:s")) - strtotime($row1['einschreibezeit']) >= 0){
                $userid = getUserIDByUsername($_SESSION['benutzer_app']);
                //Wenn die Methode getValidActivityentities mit diesen Parameterwerten True zurückgibt
                if(getValidActivityentities($row1['id_aktivitaetblock'], $userid)){
                    $activities = getActivityByActivityentityIDAndUserID($row1['id_aktivitaetblock'], $userid);
                    while($row2 = mysqli_fetch_assoc($activities)){
                        $writtenin = getWrittenIn($userid, $row2['id_aktivitaet']);
                        //Wenn die Startzeit der Aktivität nicht Vergangenheit ist und sich der Benutzer nicht eingeschrieben hat
                        if(strtotime($row2['startzeit']) - strtotime(date("Y-m-d H:i:s")) >= 0 & empty($writtenin['aktivitaet_id'])){
                            echo '
                                <form class="form_home" action="einschreiben_choice_aktivitaeten" method="post">
                                    <button class="button_home section'.getArtNameByID($id).'">
                                        <p class="p_section">'.$row1['name'].'</p>
                                    </button>
                                    <input type="hidden" name="id_aktivitaetsblock" value="'.$row1['id_aktivitaetblock'].'">
                                </form>
                            ';
                            $counter++;
                            break;
                        }
                    }    
                }
            }
        }
        //Wenn es in dieser Aktivitätsart keine Aktivitätsblöcke mit einer momentan zu einschreibenden Aktivität hat
        if($counter == 0){
            $array = array();
            array_push($array, "einschreiben_choice", "validate_einschreiben_choice", "einschreiben_choice_aktivitaeten", "validate_einschreiben_choice_aktivitaeten", "einschreiben", "validate_einschreiben");
            addSessionInvalid($array);
        }
        //Wenn es in dieser Aktivitätsart mehrere Aktivitätsblöcke mit einer momentan zu einschreibenden Aktivität hat
        else if($counter > 0){
            $array = array();
            array_push($array, "einschreiben_choice_aktivitaeten", "validate_einschreiben_choice_aktivitaeten");
            removeSessionInvalid($array);
        }
        echo '
            <form action="validate_einschreiben_choice" method="post">
                <input class="button_zurück" type="submit" name="submit_btn" value="Zurück"/>
            </form>
        ';
    }
    else{
        header('Location: home');
    }
?>