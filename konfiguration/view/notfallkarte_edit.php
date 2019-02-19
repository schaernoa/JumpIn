<div class="div_main">
    <?php
        //Stack ausgeben
        echo '<p id="p_stack">'.$_SESSION['stack'].'</p>';

        //Den Datensatz der Notfallkategorie mit der ID aus der Session holen
        $idnotfallkategorie = intval($_SESSION['id_notfallkategorie']);
        $datensatz = getEmergencyCategoryByID($idnotfallkategorie);

        echo '
        <div class="div_form">
            <form action="validate_notfallkarte_edit" method="post">
                <p class="p_form_title">
                    Notfallkartenkategorie bearbeiten
                </p>
        ';
        //Fehlercode integrieren
        require_once('error.php');
        echo '
                <p class="p_form">Notfallname</p>
                <input class="forms_textfield" type="text" name="name" value="'.$datensatz['name'].'"/>
                <br>
                <p class="p_form">Notfallinfo</p>
                <input class="forms_textfield" type="text" name="info" value="'.$datensatz['info'].'"/>
                <br>
                <input class="button_weiter" type="submit" name="submit_btn" value="Ändern"/>
                <input class="button_zurück" type="submit" name="submit_btn" value="Zurück"/>
            </form>
        </div>
        ';
    ?>
</div>