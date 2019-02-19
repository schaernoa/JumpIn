<div class="div_main">
    <?php
        //Stack ausgbeen
        echo '<p id="p_stack">'.$_SESSION['stack'].'</p>';
    ?>
    <div class="div_form">
        <form action="validate_aktivitaetsart_add" method="post">
            <p class="p_form_title">
                Aktivitätsart hinzufügen
            </p>
            <?php
                require_once('error.php');
            ?>
            <p class="p_form">Aktivitätsartname</p>
            <input class="forms_textfield" type="text" name="aktivitaetsartname"/>
            <br>
            <p class="p_form">Einschreiben</p>
            <input id="froms_radio_left" class="forms_radio" type="radio" name="einschreiben" value="true">
            <label for="true">Ja</label>
            <input class="forms_radio" type="radio" name="einschreiben" value="false" checked>
            <label for="false">Nein</label>
            <br>
            <input class="button_weiter" type="submit" name="submit_btn" value="Erstellen"/>
            <input class="button_zurück" type="submit" name="submit_btn" value="Zurück"/>
        </form>
    </div>
</div>