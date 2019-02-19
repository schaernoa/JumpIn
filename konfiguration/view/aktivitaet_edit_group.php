<div class="div_main">
    <?php
        //Error Session leeren
        $_SESSION['error'] = NULL;
        //Stack ausgeben
        echo '<p id="p_stack">'.$_SESSION['stack'].'</p>';
    ?>
    <div class="div_form">
        <p class="p_form_title">
            Gruppen für diese Aktivität bearbeiten
        </p>
        <form action="validate_aktivitaet_edit_group" method="post">
            <div class="div_forms_checkbox">
                <?php
                    //Alle Gruppen holen
                    $gruppenabfrage = getAllGroups();

                    //die AktivitätID aus der Session holen und all deren Gruppen holen
                    $id = $_SESSION['id_aktivitaet'];
                    $gruppenaktivitaetabfrage = getAllActivityGroupsByActivityID($id);

                    //Array $gruppen mit allen Gruppen füllen und Array $gruppenaktivitaeten mit denen der Aktivität der Session füllen
                    $gruppen = array();
                    $gruppenaktivitaeten = array();
                    while ($row = mysqli_fetch_array($gruppenabfrage)){
                        $gruppen[] = $row;
                    }            
                    while ($row = mysqli_fetch_array($gruppenaktivitaetabfrage)){
                        $gruppenaktivitaeten[] = $row;
                    }

                    $iteratedarray = [];
                    //Für jede Gruppe
                    foreach($gruppen as $rowx){
                        //Für jede Gruppe der Aktivität
                        foreach($gruppenaktivitaeten as $rowy){
                            //Wenn die ID übereinstimmt
                            if($rowx['id_gruppe'] == $rowy['gruppe_id']){
                                //checkbox als gecheckt ausgeben
                                echo '
                                    <input class="forms_checkbox" type="checkbox" name="group[]"
                                    value="'.$rowx['name'].'" checked> '.$rowx['name'].'<br>
                                ';
                                $iteratedarray[] = $rowx['id_gruppe'];
                            }
                        }
                        //Wenn nicht übereinstimmtw
                        if(!in_array($rowx['id_gruppe'],$iteratedarray)){
                            //checkbox als nicht checked ausgeben
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