<div class="div_main">
    <?php
        //Error Session leeren
        $_SESSION['error'] = NULL;
        //Stack ausgeben
        echo '<p id="p_stack">'.$_SESSION['stack'].'</p>';
    ?>
    <div class="div_form">
        <p class="p_form_title">
            Benutzer zu Gruppen hinzufügen
        </p>
        <form action="validate_user_group_add" method="post">
            <div class="div_forms_checkbox">
                <?php
                    //Hole alle Gruppen
                    $gruppenabfrage = getAllGroups();

                    //Für jede Gruppe
                    while($row = mysqli_fetch_assoc($gruppenabfrage)){
                        echo '
                            <input class="forms_checkbox" type="checkbox" name="group[]"
                            value="'.$row['name'].'"> '.$row['name'].'<br>
                        ';
                    }
                ?>
                <input class="button_weiter" type="submit" name="submit_btn" value="Erstellen">
                <input class="button_zurück" type="submit" name="submit_btn" value="Zurück">
            </div>
        </form>
    </div>
</div>