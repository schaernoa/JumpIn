<div class="div_main">
    <?php
        //Stack ausgeben
        echo '<p id="p_stack">'.$_SESSION['stack'].'</p>';

        //AktivitätID aus der Session holen
        $activityid = $_SESSION['id_aktivitaet'];
        //Datensatz der ID holen
        $datensatz = getActivityByID($activityid);

        echo '
        <div class="div_form">
            <form action="validate_aktivitaet_edit_einschreiben" method="post">
                <p class="p_form_title">
                    Weitere Informationen für das Einschreiben bearbeiten
                </p>
        ';
        //Fehlercode
        require_once('error.php');
        echo'
                <p class="p_form">Aktivitätsblock</p>
                <select class="forms_dropdown" name="aktivitaetblock">
                    <option value="null">-</option>
                    '.getActivityentities($datensatz['aktivitaetblock_id'], getArtIDByName($_SESSION['aktivitaetsart'])).'
                </select>
                <p class="p_form">Anzahl Teilnehmer</p>
                <input class="forms_textfield" type="text" name="anzahlteilnehmer" value="'.$datensatz['anzahlteilnehmer'].'"/>
                <br>
                <input class="button_weiter" type="submit" name="submit_btn" value="Weiter"/>
            </form>
        <div>
        ';
        
        //Methode um alle Aktivitätsblöcke einer bestimmten Aktivitätsart in einem String als Select-Optionen zu holen
        //$activityentityid der Aktivitätsblock
        //$artid die Aktivitätsart
        function getActivityentities($activityentityid, $artid){
            $allarts = getAllActivityEntities();
            $result = '';
            //Für alle Aktivitätblöcke
            while($row = mysqli_fetch_assoc($allarts)){
                //Wenn die Aktivitätart die selbe wie der parameter ist
                if($row['art_id'] == $artid){
                    //Wenn es der Aktivitätblock wie im Parameter ist
                    if($activityentityid == $row['id_aktivitaetblock']){
                        $result .= '<option value="'.$row['name'].'" selected>'.$row['name'].'</option>';
                    }
                    else{
                        $result .= '<option value="'.$row['name'].'">'.$row['name'].'</option>';
                    }
                }
            }
            return $result;
        }
    ?>
</div>