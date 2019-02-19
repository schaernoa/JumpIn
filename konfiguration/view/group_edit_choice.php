<div class="div_main">
    <?php
        //Error Session leeren
        $_SESSION['error'] = NULL;
        //Stack ausgeben
        echo '<p id="p_stack">'.$_SESSION['stack'].'</p>';
    ?>
    <div class="div_form">
        <p class="p_form_title">
            Gruppe zum bearbeiten auswählen
        </p>
        <table>
            <tr>
                <th>Gruppenname</th>
                <th>Level</th>
                <th></th>
            </tr>
            <?php
                //Alle Gruppen holen
                $allgroups = getAllGroups();
                //für jede Gruppe
                while($row = mysqli_fetch_assoc($allgroups)){
                    //Wenn die Gruppe admin oder coach ist
                    if(strtolower($row['name']) == "admin" | strtolower($row['name']) == "coach"){
                        echo '
                            <tr>
                                <form action="validate_group_edit_choice" method="post">
                                    <th>
                                        '.$row['name'].'
                                    </th>
                                    <th>
                                        '.$row['level'].'
                                    </th>
                                    <th>
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
                                <form action="validate_group_edit_choice" method="post">
                                    <th>
                                        '.$row['name'].'
                                    </th>
                                    <th>
                                        '.$row['level'].'
                                    </th>
                                    <th>
                                        <input type="hidden" name="id_gruppe" value="'.$row['id_gruppe'].'"/>
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