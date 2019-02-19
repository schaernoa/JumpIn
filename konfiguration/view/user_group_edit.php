<div class="div_main">
    <?php
        //Error Session leeren
        $_SESSION['error'] = NULL;
        //Stack ausgeben
        echo '<p id="p_stack">'.$_SESSION['stack'].'</p>';
    ?>
    <div class="div_form">
        <p class="p_form_title">
            Gruppen von Benutzer bearbeiten
        </p>
        <form action="validate_user_group_edit" method="post">
            <div class="div_forms_checkbox">
                <?php
                    //Hole alle Gruppen
                    $gruppenabfrage = getAllGroups();

                    //Hole alle Gruppen mit der BenutzerID
                    $id = $_SESSION['id_benutzer'];
                    $gruppenbenutzerabfrage = getAllUserGroupsByUserID($id);

                    //Fülle 2 Arrays, $gruppen mit allen Gruppen und $gruppenbenutzer mit allen Gruppen denen eine Benutzer zugewiesen ist
                    $gruppen = array();
                    $gruppenbenutzer = array();
                    while ($row = mysqli_fetch_array($gruppenabfrage)){
                        $gruppen[] = $row;
                    }            
                    while ($row = mysqli_fetch_array($gruppenbenutzerabfrage)){
                        $gruppenbenutzer[] = $row;
                    }

                    $iteratedarray = [];
                    //Für jede Gruppe
                    foreach($gruppen as $rowx){
                        //Für jede Gruppe des benutzers
                        foreach($gruppenbenutzer as $rowy){
                            //Wenn die IDs übereinstimmen
                            if($rowx['id_gruppe'] == $rowy['gruppe_id']){
                                //Gruppe als Checked ausgeben
                                echo '
                                    <input class="forms_checkbox" type="checkbox" name="group[]"
                                    value="'.$rowx['name'].'" checked> '.$rowx['name'].'<br>
                                ';
                                //zu iteriert Array hinzufügen
                                $iteratedarray[] = $rowx['id_gruppe'];
                            }
                        }
                        //Wenn Gruppe nicht in iteriert Array ist
                        if(!in_array($rowx['id_gruppe'],$iteratedarray)){
                            //Gruppe als nicht checked ausgeben
                            echo '
                                <input class="forms_checkbox" type="checkbox" name="group[]"
                                value="'.$rowx['name'].'"> '.$rowx['name'].'<br>
                            ';
                        }
                    }
                ?>
                <input class="button_weiter" type="submit" name="submit_btn" value="Ändern">
            </div>
        </form>
    </div>
</div>