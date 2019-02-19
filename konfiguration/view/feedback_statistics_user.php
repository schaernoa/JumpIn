<div class="div_main">
    <?php
        //Error Session leeren
        $_SESSION['error'] = NULL;
        //Stack ausgeben
        echo '<p id="p_stack">'.$_SESSION['stack'].'</p>';
        //Datensatz des Benutzers aus der Session holen
        $user = getUserByUsername($_SESSION['feedback_user']);
    ?>
    <div class="div_form">
        <p class="p_form_title">
            <?php
                //Titel ausgeben
                echo ''.$user['vorname'].' '.$user['name'].'`s Feedback'
            ?>
        </p>
        <?php
            //Hole alle FeedbackKategorien
            $categories = getAllFeedbackCategories();
            //Für jede Feedbackkategorie
            while($row1 = mysqli_fetch_assoc($categories)){
                //Die Frage der kategorie ausgeben
                echo '
                    <div class="div_feedback_statistik_frage">
                        '.$row1['frage'].'
                    </div>
                    <div class="div_feedback_statistik_container">
                ';
                //Das Benutzerfeedback für die Frage und den Benutzer holen
                $userfeedback = getUserFeedbackByFeedbackCategoryID($row1['id_feedbackkategorie'], $user['id_benutzer']);
                //Wenn das Feedback nicht leer ist
                if(!empty($userfeedback)){
                    //Für jedes gegebene Feedback des Benutzers
                    while($row2 = mysqli_fetch_assoc($userfeedback)){
                        //Hole die Ausgewählte Option
                        $option = getOptionByOptionIDAndFeedbackcategoryID($row2['optionen_id'], $row2['feedbackkategorie_id']);
                        //Gib die Ausgewählte Option und die bemerkung aus
                        echo '
                            <div class="div_feedback_statistik_answer">
                                '.$option['antwort'].'
                            </div>
                            <div class="div_feedback_statistik_bemerkung">
                                '.$row2['bemerkung'].'
                            </div>
                        ';
                    }
                }
                else{
                    //Wenn es nicht beantwortet wurde
                    echo '<p class="p_feedback_statistik_noanswer">Keine Antwort</p>';
                }
                echo '
                    </div>
                    <br>
                ';
            }
        ?>
        <form action="validate_feedback_statistics_user" method="post">
            <input class="button_zurück" type="submit" name="submit_btn" value="Zurück">
        </form>
    </div>
</div>