<div class="div_main">
    <?php
        //Error Session leeren
        $_SESSION['error'] = NULL;
        //Stack ausgeben
        echo '<p id="p_stack">'.$_SESSION['stack'].'</p>';
    ?>
    <div class="div_form">
        <p class="p_form_title">
            Steckbriefkategorie zum bearbeiten auswählen
        </p>
        <table>
            <tr>
                <th>Name</th>
                <th>Obligation</th>
                <th>Einzeiler</th>
                <th></th>
            </tr>
            <?php
                //Alle Steckbriefkategorien holen
                $allcategories = getAllCharacteristicsCategories();
                //Für jede Steckbriefkategorie
                while($row = mysqli_fetch_assoc($allcategories)){
                    echo '
                        <tr>
                            <form action="validate_steckbrief_edit_choice" method="post">
                                <th>
                                    '.$row['name'].'
                                </th>
                                <th>
                                    '.getJaNein($row['obligation']).'
                                </th>
                                <th>
                                    '.getJaNein($row['einzeiler']).'
                                </th>
                                <th>
                                    <input type="hidden" name="id_steckbriefkategorie" value="'.$row['id_steckbriefkategorie'].'"/>
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