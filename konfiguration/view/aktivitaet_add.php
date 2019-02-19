<div class="div_main">
    <?php
        //Stack ausgeben
        echo '<p id="p_stack">'.$_SESSION['stack'].'</p>';
    ?>
    <div class="div_form">
        <form action="validate_aktivitaet_add" method="post">
            <p class="p_form_title">
                Neue Aktivität erstellen
            </p>
            <?php
                require_once('error.php');
            ?>
            <p class="p_form">Aktivitätsname</p>
            <input class="forms_textfield" type="text" name="aktivitaetsname"/>
		    <br>
		    <p class="p_form">Aktivitätsart</p>
		    <select class="forms_dropdown" name="aktivitaetsart">
                <option value="null">-</option>
                <?php
                //Alle Aktivitätsarten holen
                    $allarts = getAllArts();
                    //Für jede Aktivitätsart
                    while($row = mysqli_fetch_assoc($allarts)){
                        echo '
                            <option value="'.$row['name'].'">'.$row['name'].'</option>
                        ';
                    }
                ?>
            </select>
            <br>
            <p class="p_form">Treffpunkt</p>
		    <input class="forms_textfield" type="text" name="treffpunkt"/>
            <br>
            <p class="p_form">Info</p>
		    <textarea class="forms_textarea" name="info" maxlength="500"></textarea>
            <br>
            <p class="p_form">Startzeit</p>
            <input class="forms_date" type="date" name="startdate"/>
            <input class="forms_time" type="time" name="starttime"/>
            <br>
            <p class="p_form">Endzeit</p>
            <input class="forms_date" type="date" name="enddate"/>
            <input class="forms_time" type="time" name="endtime"/>
            <br>
            <input class="button_weiter" type="submit" name="submit_btn" value="Weiter"/>
            <input class="button_zurück" type="submit" name="submit_btn" value="Zurück"/>
        </form>
    </div>
</div>