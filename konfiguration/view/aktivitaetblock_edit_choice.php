<div class="div_main">
    <?php
        //Error Session leeren
        $_SESSION['error'] = NULL;
        //Stack ausgeben
        echo '<p id="p_stack">'.$_SESSION['stack'].'</p>';
    ?>
    <div class="div_form">
        <p class="p_form_title">
            Aktivitätsblock zum bearbeiten auswählen
        </p>
        <table>
            <tr>
                <th>Aktivitätsblockname</th>
                <th>Aktivitätsart</th>
                <th></th>
            </tr>
            <?php
                //Alle Aktivitätblöcke holen
                $allactivitiyentities = getAllActivityEntities();
                //Für jeden Aktivitätblock
                while($row = mysqli_fetch_assoc($allactivitiyentities)){
                    echo '
                        <tr>
                            <form action="validate_aktivitaetblock_edit_choice" method="post">
                                <th>
                                    '.$row['name'].'
                                </th>
                                <th>
                                    '.getArtNameByID($row['art_id']).'
                                </th>
                                <th>
                                    <input type="hidden" name="id_aktivitaetblock" value="'.$row['id_aktivitaetblock'].'"/>
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