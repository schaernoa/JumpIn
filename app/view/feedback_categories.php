<?php
    $startid;
    //Hole die richtige AktivitätID. Entweder aus Session oder aus Post
    if(empty($_POST['startid'])){
        $startid = intval($_SESSION['startid']);
    }
    else{
        $startid = intval($_POST['startid']);
    }
    if(!empty($startid)){
        $feedbackcategory;
        $feedbackcategories = getAllFeedbackCategories();
        if(!empty($feedbackcategories)){
            $counter = 1;
            while($row = mysqli_fetch_assoc($feedbackcategories)){
                if($counter == $startid){
                    $feedbackcategory = $row;
                }
                $counter++;
            }
            //Die Breite der Fortschritt-Leiste berechnen
            $width = round((100 / ($counter - 1)) * $startid, 1);
            $margin = $width / 2;
            //Die Fortschritt-Leiste echoen
            echo '
                <form action="validate_feedback_categories" method="post">
                    <div class="div_progress">
                        <span style="width: '.$width.'%"></span>
                    </div>
                    <h2>'.$feedbackcategory['frage'].'</h2>
            ';
            //Hole den Fehlermeldung Code
            require_once('error.php');
            $options = getAllOptionsByFeedbackID($feedbackcategory['id_feedbackkategorie']);
            //Für jede Option der Frage Radio Buttons ausgeben
            while($row = mysqli_fetch_assoc($options)){
                echo '
                    <input class="forms_radio" type="radio" name="options"
                    value="'.$row['id_optionen'].'"><p class="p_feedback_radio">'.$row['antwort'].'</p><br>
                ';
            }
            //Das Bemerkungsfeld ausgeben
            echo '
                    <p class="p_form">Bemerkung (optional)</p>
                    <textarea class="forms_textarea" name="bemerkung" maxlength="500"></textarea>
                    <input type="hidden" name="startid" value="'.($startid+1).'"/>
                    <input type="hidden" name="feedbackid" value="'.$feedbackcategory['id_feedbackkategorie'].'"/>
            ';
            //Wenn es die Letzte Feedbackfrage ist
            if($startid == ($counter - 1)){
                echo '
                        <input class="button_weiter" type="submit" name="submit_btn" value="Abschliessen"/>
                    </form>
                ';
            }
            else{
                echo '
                        <input class="button_weiter" type="submit" name="submit_btn" value="Weiter"/>
                    </form>
                ';
            }
        }
        else{
            header('Location: home');
        }
    }
    else{
        header('Location: home'); 
    }
?>