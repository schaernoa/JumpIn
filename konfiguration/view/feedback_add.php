<div class="div_main">
    <?php
        //Stack ausgeben
        echo '<p id="p_stack">'.$_SESSION['stack'].'</p>';
    ?>
    <div class="div_form">
        <form action="validate_feedback_add" method="post">
            <p class="p_form_title">
                Neue Feedbackkategorie erstellen
            </p>
            <?php
                require_once('error.php');
            ?>
            <p class="p_form">Frage des Feedbacks</p>
		    <textarea class="forms_textarea" name="frage" maxlength="300"></textarea>
            <br>
            <p class="p_form">Anzahl Antwortoptionen</p>
            <input class="forms_textfield" type="text" name="anzahloptionen"/>
            <br>
            <p class="p_form">Aufschaltszeit</p>
            <p class="p_form_comment">Es wird nur die kleinste Zeit aller Feedbackkategorien berücksichtigt</p>
            <input class="forms_date" type="date" name="aufschaltsdate"/>
            <input class="forms_time" type="time" name="aufschaltszeit"/>
            <br>
            <input class="button_weiter" type="submit" name="submit_btn" value="Weiter"/>
            <input class="button_zurück" type="submit" name="submit_btn" value="Zurück"/>
        </form>
    </div>
</div>