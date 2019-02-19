<h2>Steckbrief</h2>
<form id="form_filter" action="validate_steckbrief_order" method="post">
    <p id="p_steckbrief_filter">Filter</p>
	<select class="steckbrief_dropdown" name="gruppe">
        <option value="null">-</option>
        <?php
            //Error Session leeren
            $_SESSION['error'] = NULL;
            //Wenn zuvor ein Filter ausgewählt wurde
            if(!empty($_SESSION['groupselected'])){
                $groupid = $_SESSION['groupselected'];
            }
            else{
                $groupid = 0;
            }
            $groupselected = 0;
            $groups = getAllGroups();
            $notGroupGroups = $_SESSION['notGroupGroups'];
            //Für alle Gruppen
            while($row = mysqli_fetch_assoc($groups)){
                //Wenn es eine filterbare Gruppe ist
                if(!in_array(strtolower($row['name']), $notGroupGroups)){
                    //Wenn es die ausgewählte Gruppe ist
                    if($groupid == $row['id_gruppe']){
                        $groupselected = $row['id_gruppe'];
                        echo '
                            <option value="'.$row['id_gruppe'].'" selected>'.$row['name'].'</option>
                        ';  
                    }
                    else{
                        echo '
                            <option value="'.$row['id_gruppe'].'">'.$row['name'].'</option>
                        ';
                    }
                }
            }
        ?>
    </select>
    <input id="button_filter" type="submit" name="submit_btn" value="Ändern">
</form>
<?php
    $user;
    //Wenn keine Gruppe als Filter ausgewählt wurde
    if($groupselected == 0){
        $user = getAllUserOrdered();
    }
    else{
        //hole nur die benutzer einer bestimmten Gruppe
        $user = getUserByGroupID($groupselected);
    }
    $anzahleintraege = 0;
    $notUserUsers = $_SESSION['notUserUsers'];
    //Für alle geholten Benutzer
    while($row = mysqli_fetch_assoc($user)){
        if(!in_array(strtolower($row['benutzername']), $notUserUsers)){
            $resultarray = getGroupByUsernameAndLevel($row['benutzername']);
            $anzahleintraege++;
            echo '
                <form action="steckbrief_view" method="post">
                    <button class="button_steckbrief">
                        <div class="div_steckbrief_left">
                        ';
                            if(file_exists('./userimages/'.$row['id_benutzer'].'.png')){
                                echo '<img class="img_steckbrief" src="./userimages/'.$row['id_benutzer'].'.png?t='.filemtime('./userimages/'.$row['id_benutzer'].'.png').'" alt="Profilbild"/>';
                            }
                            else{
                                echo '<img class="img_steckbrief" src="./image/benutzer.jpg" alt="Profilbild"/>';
                            }
                        echo'
                        </div>
                        <div class="div_steckbrief_right">
                            <p class="p_steckbrief_name">'.$row['vorname'].' '.$row['name'].'</p>
                            <p class="p_steckbrief_gruppe">'.$resultarray['name'].'</p>
                        </div>
                    </button>
                    <input type="hidden" name="id_user" value="'.$row['id_benutzer'].'">
                    <input type="hidden" name="mode" value="steckbrief">
                </form>
            ';
        }
    }
    //Wenn es noch keine Einträge hat
    if($anzahleintraege == 0){
        echo '
            <div id="no_characteristics">
                <p id="p_no_characteristics">
                    Keine Steckbriefe
                </p>
            </div>
        ';
    }
?>