<div class="div_main">
    <?php
        //Stack ausgeben
        echo '<p id="p_stack">'.$_SESSION['stack'].'</p>';

        //Der Datensatz der Gruppe durch die Id aus der Session holen
        $idgroup = intval($_SESSION['id_gruppe']);
        $datensatz = getGroupByID($idgroup);

        echo '
            <div class="div_form">
                <form action="validate_group_edit" method="post">
                    <p class="p_form_title">
                        Gruppe bearbeiten
                    </p>
        ';
        //Fehlercode integrieren
        require_once('error.php');
        echo '
                    <p class="p_form">Gruppenname</p>
                    <input class="forms_textfield" type="text" name="gruppenname" value="'.$datensatz['name'].'"/>
                    <br>
                    <p class="p_form">Level</p>
                    <p class="p_form_comment">Das höchste Level einer Gruppe eines Benutzers wird beim Steckbrief des Benutzers angezeigt!</p>
                    <input class="forms_textfield" type="text" name="level" value="'.$datensatz['level'].'"/>
		            <br>
                    <input class="button_weiter" type="submit" name="submit_btn" value="Ändern"/>
                    <input class="button_zurück" type="submit" name="submit_btn" value="Zurück"/>
                </form>
            </div>
        ';
    ?>
</div>