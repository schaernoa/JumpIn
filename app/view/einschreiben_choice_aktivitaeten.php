<?php
    //Error Session leeren
    $_SESSION['error'] = NULL;
    $id;
    //Hole die richtige AktivitätsblockID. Entweder aus Session oder aus Post
    if(empty($_POST['id_aktivitaetsblock'])){
        $id = intval($_SESSION['id_aktivitaetsblock']);
        $_SESSION['id_aktivitaetsblock'] = $id;
    }
    else{
        $id = $_POST['id_aktivitaetsblock'];
        $_SESSION['id_aktivitaetsblock'] = $id;
    }
    if(!empty($id)){
        echo '
            <h2>Aktivitäten zum einschreiben</h2>
            <p class="p_untertitel">Hier kannst du dich in eine Aktivität des Aktivitätblockes <b>'.getActivityentityNameByID($id).'</b> einschreiben.</p>
        ';
        $counter = 0;
        $activities = getActivityByActivityentityID($id);
        $userid = getUserIDByUsername($_SESSION['benutzer_app']);
        while($row = mysqli_fetch_assoc($activities)){
            $writtenin = getWrittenIn($userid, $row['id_aktivitaet']);
            //Wenn die Startzeit der Aktivität nicht Vergangenheit ist und sich der Benutzer nicht eingeschrieben hat
            if(strtotime($row['startzeit']) - strtotime(date("Y-m-d H:i:s")) >= 0 & empty($writtenin['aktivitaet_id'])){
                echo '
                    <form action="einschreiben" method="post">
                        <button class="button_steckbrief">
                            <div class="div_einschreiben">
                                <p class="p_steckbrief_name">
                                        '.$row['aktivitaetsname'].'   
                                </p>
                                <p class="p_steckbrief_gruppe">
                                    '.getDateString($row['startzeit']).' '.getHours($row['startzeit']).' - '.getHours($row['endzeit']).' Uhr
                                </p>
                            </div>
                        </button>
                        <input type="hidden" name="id_aktivitaet" value="'.$row['id_aktivitaet'].'">
                    </form>
                ';
                $counter++;
            }
        }
        if($counter == 0){}
        //Wenn es in diesem Aktivitätsblock eine oder mehrere momentan zu einschreibende Aktivitäten hat
        else if($counter > 0){           
            $array = array();
            array_push($array, "einschreiben", "validate_einschreiben");
            removeSessionInvalid($array);
        }
        echo '
            <form action="validate_einschreiben_choice_aktivitaeten" method="post">
                <input class="button_zurück" type="submit" name="submit_btn" value="Zurück"/>
            </form>
        ';
    }
    else{
        header('Location: home');
    }
?>