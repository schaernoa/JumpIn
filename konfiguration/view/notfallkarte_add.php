<div class="div_main">
    <?php
        //Stack ausgeben
        echo '<p id="p_stack">'.$_SESSION['stack'].'</p>';
    ?>
    <div class="div_form">
        <form action="validate_notfallkarte_add" method="post">
            <p class="p_form_title">
                Neue Notfallkartenkategorie erstellen
            </p>
            <?php
                require_once('error.php');
            ?>
            <p class="p_form">Notfallname</p>
            <input class="forms_textfield" type="text" name="name"/>
		    <br>
            <p class="p_form">Notfallinfo</p>
            <input class="forms_textfield" type="text" name="info"/>
		    <br>
            <input class="button_weiter" type="submit" name="submit_btn" value="Erstellen"/>
            <input class="button_zurück" type="submit" name="submit_btn" value="Zurück"/>
        </form>
    </div>
</div>