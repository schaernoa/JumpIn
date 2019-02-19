<div class="div_main">
    <?php
        //Stack ausgeben
        echo '<p id="p_stack">'.$_SESSION['stack'].'</p>';

        //Mit der AktivitätblockID den Datensatz dazu holen
        $idart = intval($_SESSION['id_aktivitaetblock']);
        $datensatz = getActivityentityByID($idart);

        echo '
            <div class="div_form">
                <form action="validate_aktivitaetblock_edit" method="post">
                    <p class="p_form_title">
                        Aktivitätsblock bearbeiten
                    </p>
        ';
        //Fehlercode
        require_once('error.php');
        echo '        
                    <p class="p_form">Aktivitätsblockname</p>
                    <input class="forms_textfield" type="text" name="name" value="'.$datensatz['name'].'"/>
		            <br>
		            <p class="p_form">Aktivitätsart</p>
		            <select class="forms_dropdown" name="aktivitaetsart">
                        '.getArtEinschreiben($datensatz['art_id']).'
                    </select>
                    <br>
                    <p class="p_form">Aufschaltzeit zum einschreiben</p>
                    <input class="forms_date" type="date" name="writeindate" value="'.returnDate($datensatz['einschreibezeit']).'"/>
                    <input class="forms_time" type="time" name="writeintime" value="'.returnTime($datensatz['einschreibezeit']).'"/>
                    <br>
                    <input class="button_weiter" type="submit" name="submit_btn" value="Ändern"/>
                    <input class="button_zurück" type="submit" name="submit_btn" value="Zurück"/>
                </form>
            </div>
        ';
    ?>
</div>