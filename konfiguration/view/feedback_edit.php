<div class="div_main">
    <?php
        //Stack ausgeben
        echo '<p id="p_stack">'.$_SESSION['stack'].'</p>';

        //FeedbackKategorie Datensatz mit der ID aus der Session holen
        $idfeedbackkategorie = intval($_SESSION['id_feedbackkategorie']);
        $datensatz = getFeedbackCategoryByID($idfeedbackkategorie);

        echo '
        <div class="div_form">
            <form action="validate_feedback_edit" method="post">
                <p class="p_form_title">
                    Feedbackkategorie bearbeiten
                </p>
        ';
        //Fehlercode
        require_once('error.php');
        echo '
                <p class="p_form">Frage des Feedbacks</p>
		        <textarea class="forms_textarea" name="frage" maxlength="300">'.$datensatz['frage'].'</textarea>
                <br>
                <p class="p_form">Anzahl Antwortoptionen</p>
                <input class="forms_textfield" type="text" name="anzahloptionen" value="'.$datensatz['anzahloptionen'].'"/>
                <br>
                <p class="p_form">Aufschaltszeit</p>
                <p class="p_form_comment">Es wird nur die kleinste Zeit aller Feedbackkategorien berücksichtigt</p>
                <input class="forms_date" type="date" name="aufschaltsdate" value="'.returnDate($datensatz['aufschaltszeit']).'"/>
                <input class="forms_time" type="time" name="aufschaltszeit" value="'.returnTime($datensatz['aufschaltszeit']).'"/>
                <br>
                <input class="button_weiter" type="submit" name="submit_btn" value="Weiter"/>
                <input class="button_zurück" type="submit" name="submit_btn" value="Zurück"/>
            </form>
        <div class="div_form">
        ';
        //Anzahloptionen in Session speichern
        $_SESSION['feedbackkategorie_oldoptions'] = $datensatz['anzahloptionen'];
    ?>
</div>