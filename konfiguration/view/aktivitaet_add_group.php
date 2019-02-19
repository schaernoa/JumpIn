<div class="div_main">
    <?php
        //Error Session leeren
        $_SESSION['error'] = NULL;
        //Stack ausgeben
        echo '<p id="p_stack">'.$_SESSION['stack'].'</p>';
    ?>
    <div class="div_form">
        <p class="p_form_title">
            Gruppen für diese Aktivität auswählen
        </p>
        <form action="validate_aktivitaet_add_group" method="post">
            <div class="div_forms_checkbox">
                <?php
                    //Alle Gruppen holen
                    $gruppenabfrage = getAllGroups();
                    //Für jede Gruppe
                    while($row = mysqli_fetch_assoc($gruppenabfrage)){
                        //Checkbox mit Name ausgeben
                        echo '
                            <input class="forms_checkbox" type="checkbox" name="group[]"
                            value="'.$row['name'].'"> '.$row['name'].'<br>
                        ';
                    }
                ?>
                <input class="button_weiter" type="submit" name="submit_btn" value="Erstellen">
            </div>
        </form>
    </div>
</div>