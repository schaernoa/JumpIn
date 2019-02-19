<?php
    //Hole die richtige SteckbriefID. Entweder aus Session oder aus Post
    if(empty($_POST['id_user'])){
        $userid = $_SESSION['steckbrief_id'];
    }
    else{
        $_SESSION['steckbrief_id'] = $_POST['id_user'];
        $userid = $_SESSION['steckbrief_id'];
    }
    if(!empty($userid)){
        if($_POST['mode'] == "steckbrief"){
            $_SESSION['mode'] = $_POST['mode'];
        }
        //Wenn es dein eigner Steckbrief ist
        if($userid == getUserIDByUsername($_SESSION['benutzer_app'])){
            $user = getUserByID($userid);
            echo '
                <h2>Dein Steckbrief</h2>
                <p class="p_untertitel">Gefällt dir etwas an deinem Steckbrief nicht mehr? Kein Problem, verändere ihn hier.</p>
            ';
            //Hole den Fehlermeldung Code
            require_once('error.php');
            echo '
                <form id="editForm" action="validate_steckbrief_view" method="post" enctype="multipart/form-data"></form>
                <form id="deleteForm" action="validate_steckbrief_loeschen" method="post"></form>
                <p class="p_form">Bild ändern</p>
                <div class="div_steckbrief_details_blocker">
                ';
                    if(file_exists('./userimages/'.$user['id_benutzer'].'.png')){
                        echo '<img class="img_steckbrief_details" src="./userimages/'.$user['id_benutzer'].'.png?t='.filemtime('./userimages/'.$user['id_benutzer'].'.png').'" alt="Profilbild"/>';
                    }
                    else{
                        echo '<img class="img_steckbrief_details" src="./image/benutzer.jpg" alt="Profilbild"/>';
                    }
                    echo '
                    <input class="forms_file_details" type="file" accept=".jpg, .jpeg, .png" name="bild" form="editForm"/>
                </div>
            ';
            $steckbriefkategorien = getCharacteristicsCategoryByObligation();
            //Für jede obligatorische Steckbriefkategorie
            while($row = mysqli_fetch_assoc($steckbriefkategorien)){
                //Hole die Antwort zur Kategorie
                $answerarray = getCharacteristicsByUserIDAndCharacteristicsID($user['id_benutzer'], $row['id_steckbriefkategorie']);
                //Wenn es ein Einzeiler ist
                if($row['einzeiler'] == "1"){
                    echo '
                        <p class="p_form">'.$row['name'].'</p>
                        <input class="forms_login" type="text" name="'.$row['id_steckbriefkategorie'].'" value="'.$answerarray['antwort'].'" form="editForm"/>
                        <input type="hidden" name="steckbrief[]" value="'.$row['id_steckbriefkategorie'].'" form="editForm"/>
                        <br>
                    ';
                }
                else{
                    echo '
                        <p class="p_form">'.$row['name'].'</p>
                        <textarea class="forms_textarea" name="'.$row['id_steckbriefkategorie'].'" maxlength="300" form="editForm">'.$answerarray['antwort'].'</textarea>
                        <input type="hidden" name="steckbrief[]" value="'.$row['id_steckbriefkategorie'].'" form="editForm"/>
                        <br>
                    ';
                }
            }
            $steckbriefkategorien = getCharacteristicsByUserIDAndObligation($user['id_benutzer']);
            $steckbriefkategorienarray = [];
            $numbersteckbrief = 0;
            while($row = mysqli_fetch_assoc($steckbriefkategorien)){
                $numbersteckbrief++;
                array_push($steckbriefkategorienarray, $row);
            }
            //Für jede nicht obligatorische Steckbriefkategorie
            foreach($steckbriefkategorienarray as $row){
                //Wenn es mehr als 1 Nicht obligatorische Steckbriefkategorie ist, dann kann man sie auch löschen
                if($numbersteckbrief > 1){
                    if($row['einzeiler'] == "1"){
                        echo '
                            <form id="'.$row['id_steckbriefkategorie'].'" action="validate_steckbrief_loeschen" method="post">
                            <p class="p_form">'.$row['name'].'</p>
                            <input class="forms_login_löschen" type="text" name="'.$row['id_steckbriefkategorie'].'" value="'.$row['antwort'].'" form="editForm"/>
                            <input class="button_löschen" type="submit" name="submit_btn" value="Löschen" form="'.$row['id_steckbriefkategorie'].'"/>
                            <input type="hidden" name="steckbrief[]" value="'.$row['id_steckbriefkategorie'].'" form="editForm"/>
                            <input type="hidden" name="kategorielöschen" value="'.$row['id_steckbriefkategorie'].'" form="'.$row['id_steckbriefkategorie'].'"/>
                            </form>
                            <br>
                        ';
                    }
                    else{
                        echo '
                            <form id="'.$row['id_steckbriefkategorie'].'" action="validate_steckbrief_loeschen" method="post">
                                <p class="p_form">'.$row['name'].'</p>
                                <textarea class="forms_textarea_löschen" name="'.$row['id_steckbriefkategorie'].'" maxlength="300" form="editForm">'.$row['antwort'].'</textarea>
                                <input class="button_löschen" type="submit" name="submit_btn" value="Löschen" form="'.$row['id_steckbriefkategorie'].'"/>
                                <input type="hidden" name="steckbrief[]" value="'.$row['id_steckbriefkategorie'].'" form="editForm"/>
                                <input type="hidden" name="kategorielöschen" value="'.$row['id_steckbriefkategorie'].'" form="'.$row['id_steckbriefkategorie'].'"/>
                            </form>
                            <br>
                        ';
                    }
                }
                //Wenn es nur 1 freiwillige Steckbriefkategorie ist
                else if($numbersteckbrief == 1){
                    echo '
                        <p class="p_form">'.$row['name'].'</p>
                        <input type="hidden" name="steckbrief[]" value="'.$row['id_steckbriefkategorie'].'" form="editForm"/>
                    ';
                    //Wenn es ein einzeiler ist
                    if($row['einzeiler'] == "1"){
                        echo '
                            <input class="forms_login" type="text" name="'.$row['id_steckbriefkategorie'].'" value="'.$row['antwort'].'" form="editForm"/>
                            <br>
                        ';
                    }
                    else{
                        echo '
                            <textarea class="forms_textarea" name="'.$row['id_steckbriefkategorie'].'" maxlength="300" form="editForm">'.$row['antwort'].'</textarea>
                            <br>
                        ';
                    }
                }
            }
            echo '
                <input class="button_hinzufügen" type="submit" name="submit_btn" value="Kategorie hinzufügen" form="editForm"/>
                <input class="button_weiter" type="submit" name="submit_btn" value="Ändern" form="editForm"/>
                <input class="button_zurück" type="submit" name="submit_btn" value="Zurück" form="editForm"/>
            ';
        }
        //Wenn es nicht dein eigener Steckbrief ist
        else{
            $user = getUserByID($userid);
            echo '
                <h2>'.$user['vorname'].' '.$user['name'].'</h2>
                <form action="validate_steckbrief_view" method="post">
                ';
                if(file_exists('./userimages/'.$user['id_benutzer'].'.png')){
                    echo '<img class="img_steckbrief_details_dontknow" src="./userimages/'.$user['id_benutzer'].'.png?t='.filemtime('./userimages/'.$user['id_benutzer'].'.png').'" alt="Profilbild"/>';
                }
                else{
                    echo '<img class="img_steckbrief_details_dontknow" src="./image/benutzer.jpg" alt="Profilbild"/>';
                }
                echo'
                <div class="space_blocker"></div>
            ';
            $steckbriefkategorien = getCharacteristicsCategoryByObligation();
            //Für alle obligatorischen Steckbriefkategorien
            while($row = mysqli_fetch_assoc($steckbriefkategorien)){
                //Hole Antwort zur Steckbriefkategorie
                $answerarray = getCharacteristicsByUserIDAndCharacteristicsID($user['id_benutzer'], $row['id_steckbriefkategorie']);
                //Wenn es eine Antwort hat
                if(strlen($answerarray['antwort']) > 0){
                    echo '
                        <p class="p_form">'.$row['name'].'</p>
                        <p class="p_details">
                            '.$answerarray['antwort'].'
                        </p>
                        <br>
                    ';
                }
            }
            $steckbriefkategorien = getCharacteristicsByUserIDAndObligation($user['id_benutzer']);
            //Für alle freiwilligen Steckbriefkategorien
            while($row = mysqli_fetch_assoc($steckbriefkategorien)){
                echo '
                    <p class="p_form">'.$row['name'].'</p>
                    <p class="p_details">
                        '.$row['antwort'].'
                    </p>
                    <br>
                ';
            }
            echo '
                    <input class="button_zurück" type="submit" name="submit_btn" value="Zurück"/>
                </form>
            ';
        }
    }
    else{
        header('Location: home');
    }
?>