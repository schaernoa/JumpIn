<div class="div_main">
    <?php
        //Error Session leeren
        $_SESSION['error'] = NULL;
        //Stack ausgeben
        echo '<p id="p_stack">'.$_SESSION['stack'].'</p>';
    ?>
    <div class="div_form">
        <p class="p_form_title">
            Benutzer zum bearbeiten auswählen
        </p>
        <table>
            <tr>
                <th>Benutzername</th>
                <th>Vorname</th>
                <th>Nachname</th>
                <th></th>
            </tr>
            <?php
                //Hole alle Benutzer
                $allusers = getAllUser();
                //Für jeden Benutzer
                while($row = mysqli_fetch_assoc($allusers)){
                    //Wenn der Benutzername Admin ist
                    if(strtolower($row['benutzername']) == "admin"){
                        echo '
                        <tr>
                            <form action="validate_user_edit_choice" method="post">
                                <th>
                                    '.$row['benutzername'].'
                                </th>
                                <th>
                                    '.$row['vorname'].'
                                </th>
                                <th>
                                    '.$row['name'].'
                                </th>
                                <th>
                                    <input type="hidden" name="id_benutzer" value="'.$row['id_benutzer'].'"/>
                                    <input class="button_weiter_table" type="submit" name="submit_btn" value="Bearbeiten" disabled/>
                                    <input class="button_delete" type="submit" name="submit_btn" value="Löschen" disabled/>
                                </th>
                            </form>  
                        </tr>  
                    ';
                    }
                    else{
                        echo '
                        <tr>
                            <form action="validate_user_edit_choice" method="post">
                                <th>
                                    '.$row['benutzername'].'
                                </th>
                                <th>
                                    '.$row['vorname'].'
                                </th>
                                <th>
                                    '.$row['name'].'
                                </th>
                                <th>
                                    <input type="hidden" name="id_benutzer" value="'.$row['id_benutzer'].'"/>
                                    <input class="button_weiter_table" type="submit" name="submit_btn" value="Bearbeiten"/>
                                    <input class="button_delete" type="submit" name="submit_btn" value="Löschen"/>
                                </th>
                            </form>  
                        </tr>  
                        ';
                    }
                }
            ?>
        </table>
        <form action="stack" method="post">
            <input class="button_zurück_choice" type="submit" name="submit_btn" value="Zurück">
        </form>
    </div>
</div>