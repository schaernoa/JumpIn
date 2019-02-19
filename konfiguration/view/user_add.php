<div class="div_main">
    <?php
        //Stack ausgeben
        echo '<p id="p_stack">'.$_SESSION['stack'].'</p>';
    ?>
    <div class="div_form">
        <form action="validate_user_add" method="post">
            <p class="p_form_title">
                Benutzer zum JumpIn hinzufügen
            </p>
            <?php
                require_once('error.php');
            ?>
            <p class="p_form">Name</p>
            <input class="forms_textfield" type="text" name="name"/>
		    <br>
		    <p class="p_form">Vorname</p>
		    <input class="forms_textfield" type="text" name="vorname"/>
            <br>
            <p class="p_form">Benutzername</p>
		    <input class="forms_textfield" type="text" name="benutzername"/>
            <br>
            <p class="p_form">Passwort</p>
		    <input class="forms_textfield" type="password" name="passwort"/>
            <br>
            <p class="p_form">Passwort wiederholen</p>
	    	<input class="forms_textfield" type="password" name="passwort2"/>
            <br>
            <input class="button_weiter" type="submit" name="submit_btn" value="Erstellen"/>
            <input class="button_zurück" type="submit" name="submit_btn" value="Zurück"/>
        </form>
    </div>
</div>