<div class="div_main">
    <?php
        //Error Session leeren
        $_SESSION['error'] = NULL;
        //Stack ausgeben
        echo '<p id="p_stack">'.$_SESSION['stack'].'</p>';
    ?>
    <div class="div_form">
        <p class="p_form_title">
            Feedbackkategorie zum bearbeiten auswählen
        </p>
        <table>
            <tr>
                <th>Feedbackfrage</th>
                <th>Antwortoptionen</th>
                <th></th>
            </tr>
            <?php
                //Alle Feedbackkategorien holen
                $allfeedbackcategories = getAllFeedbackCategories();
                //Für jede Feedbackkategorie
                while($row = mysqli_fetch_assoc($allfeedbackcategories)){
                    echo '
                        <tr>
                            <form action="validate_feedback_edit_choice" method="post">
                                <th>
                                    '.$row['frage'].'
                                </th>
                                <th>
                                    '.$row['anzahloptionen'].'
                                </th>
                                <th>
                                    <input type="hidden" name="id_feedbackkategorie" value="'.$row['id_feedbackkategorie'].'"/>
                                    <input class="button_weiter_table" type="submit" name="submit_btn" value="Bearbeiten"/>
                                    <input class="button_delete" type="submit" name="submit_btn" value="Löschen"/>
                                </th>
                            </form>  
                        </tr>  
                    ';
                }
            ?>
        </table>
        <form action="stack" method="post">
            <input class="button_zurück_choice" type="submit" name="submit_btn" value="Zurück">
        </form>
    </div>
</div>