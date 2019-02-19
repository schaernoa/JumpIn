<div class="div_main">
    <?php
        //Stack ausgeben
        echo '<p id="p_stack">'.$_SESSION['stack'].'</p>';
    ?>
    <div class="div_form">
        <p class="p_form_title">
            Antwortoptionen von Feedbackfrage bearbeiten
        </p>
        <?php
            //Fehlercode
            require_once('error.php');
        ?>
        <form action="validate_feedback_edit_optionen" method="post">
            <div class="div_forms_checkbox">
                <?php
                    //Die FeedbackKategorie und Optionen per ID der Session holen
                    $feedbackcategory = getFeedbackCategoryByID($_SESSION['id_feedbackkategorie']);
                    $options= getAllOptionsByFeedbackID($_SESSION['id_feedbackkategorie']);
                    $x = 1;
                    //Wenn es weniger Antwortoptionen als zuvor hat
                    if($feedbackcategory['anzahloptionen'] < $_SESSION['feedbackkategorie_oldoptions']){
                        //Für jede Option
                        while($row = mysqli_fetch_assoc($options)){
                            //Nur alle Optionen Ausgeben bis das Maximum erreicht wurde
                            if($x <= $feedbackcategory['anzahloptionen']){
                                echo '<p class="p_form">Option '.$x.'</p>
                                    <textarea class="forms_textarea" name="antwort[]" maxlength="300">'.$row['antwort'].'</textarea>
                                ';
                            }
                            $x++;
                        }
                    }
                    //Wenn es mehr Antwortoptionen als zuvor hat
                    elseif($feedbackcategory['anzahloptionen'] > $_SESSION['feedbackkategorie_oldoptions']){
                        //Für jede Option in der Datenbank
                        while($row = mysqli_fetch_assoc($options)){
                            //gefüllte Option Ausgeben
                            echo '<p class="p_form">Option '.$x.'</p>
                                <textarea class="forms_textarea" name="antwort[]" maxlength="300">'.$row['antwort'].'</textarea>
                            ';
                            $x++;
                        }
                        //Für die Anzahl der Optionen die nun mehr sind 
                        for($i = 1; $i <= ($feedbackcategory['anzahloptionen'] - $_SESSION['feedbackkategorie_oldoptions']); $i++){
                            //Eine leere Option ausgeben
                            echo '<p class="p_form">Option '.$x.'</p>
                                <textarea class="forms_textarea" name="antwort[]" maxlength="300"></textarea>
                            ';
                            $x++;
                        }
                    }
                    //Wenn es gleich viele Antwortoptionen wie zuvor hat
                    else{
                        //Für jede Antwortoption in der Datenbank
                        while($row = mysqli_fetch_assoc($options)){
                            //gefüllte Antwortoption ausgeben
                            echo '<p class="p_form">Option '.$x.'</p>
                                <textarea class="forms_textarea" name="antwort[]" maxlength="300">'.$row['antwort'].'</textarea>
                            ';
                            $x++;
                        }
                    }
                ?>
                <input class="button_weiter" type="submit" name="submit_btn" value="Ändern">
            </div>
        </form>
    </div>
</div>