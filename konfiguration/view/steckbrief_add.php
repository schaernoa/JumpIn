<div class="div_main">
    <?php
        //Stack ausgeben
        echo '<p id="p_stack">'.$_SESSION['stack'].'</p>';
    ?>
    <div class="div_form">
        <form action="validate_steckbrief_add" method="post">
            <p class="p_form_title">
                Neue Steckbriefkategorie erstellen
            </p>
            <?php
                //Fehlercode integrieren
                require_once('error.php');
            ?>
            <p class="p_form">Steckbriefkategoriename</p>
            <input class="forms_textfield" type="text" name="name"/>
		    <br>
            <p class="p_form">Obligatorisch</p>
            <input id="froms_radio_left" class="forms_radio" type="radio" name="obligation" value="true" checked>
            <label for="true">Ja</label>
            <input class="forms_radio" type="radio" name="obligation" value="false">
            <label for="false">Nein</label>
            <br>
            <p class="p_form">Einzeiler</p>
            <input id="froms_radio_left" class="forms_radio" type="radio" name="einzeiler" value="true" checked>
            <label for="true">Ja</label>
            <input class="forms_radio" type="radio" name="einzeiler" value="false">
            <label for="false">Nein</label>
            <br>
            <input class="button_weiter" type="submit" name="submit_btn" value="Erstellen"/>
            <input class="button_zurück" type="submit" name="submit_btn" value="Zurück"/>
        </form>
    </div>
</div>