<div class="div_main">
    <?php
        //Stack ausgeben
        echo '<p id="p_stack">'.$_SESSION['stack'].'</p>';

        //Steckbriefkategorie datensatz mit der ID der Session holen
        $idsteckbrief = intval($_SESSION['id_steckbriefkategorie']);
        $datensatz = getCharacteristicsCategoriesByID($idsteckbrief);

        echo '
            <div class="div_form">
                <form action="validate_steckbrief_edit" method="post">
                    <p class="p_form_title">
                        Steckbriefkategorie bearbeiten
                    </p>
        ';
        //Fehlercode integrieren
        require_once('error.php');
        echo '
                    <p class="p_form">Steckbriefkategoriename</p>
                    <input class="forms_textfield" type="text" name="name" value="'.$datensatz['name'].'"/>
                    <br>
                    <p class="p_form">Obligatorisch</p>
                    '.getObligation($datensatz['obligation']).'
                    <br>
                    <p class="p_form">Einzeiler</p>
                    '.getEinzeiler($datensatz['einzeiler']).'
                    <br>
                    <input class="button_weiter" type="submit" name="submit_btn" value="Ändern"/>
                    <input class="button_zurück" type="submit" name="submit_btn" value="Zurück"/>
                </form>
            </div>
        ';
    ?>
</div>