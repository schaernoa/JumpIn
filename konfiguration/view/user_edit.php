<div class="div_main">
    <?php
        //Stack ausgeben
        echo '<p id="p_stack">'.$_SESSION['stack'].'</p>';

        //Datensatz des Benutzer mit der ID aus der Session holen 
        $idbenutzer = intval($_SESSION['id_benutzer']);
        $datensatz = getUserByID($idbenutzer);

        echo '
            <div class="div_form">
                <form action="validate_user_edit" method="post">
                    <p class="p_form_title">
                        Benutzer bearbeiten
                    </p>
        ';
        //Fehlercode integrieren
        require_once('error.php');
        echo '
                    <p class="p_form">Name</p>
                    <input class="forms_textfield" type="text" name="name" value="'.$datensatz['name'].'"/>
		            <br>
		            <p class="p_form">Vorname</p>
		            <input class="forms_textfield" type="text" name="vorname" value="'.$datensatz['vorname'].'"/>
                    <br>
                    <p class="p_form">Benutzername</p>
		            <input class="forms_textfield" type="text" name="benutzername" value="'.$datensatz['benutzername'].'"/>
                    <br>
                    <p class="p_form">Passwort</p>
		            <input class="forms_textfield" type="password" name="passwort"/>
                    <br>
                    <p class="p_form">Passwort wiederholen</p>
	    	        <input class="forms_textfield" type="password" name="passwort2"/>
                    <br>
                    <input class="button_weiter" type="submit" name="submit_btn" value="Weiter"/>
                    <input class="button_zurück" type="submit" name="submit_btn" value="Zurück"/>
            </form>
        </div>
        ';
    ?>
</div>