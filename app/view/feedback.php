<h2>Gib uns ein Feedback!</h2>
<p class="p_untertitel">Gib uns doch eine Rückmeldung wie du das diesjährige Jump-in fandest, sodass das nächste noch besser werden kann!</p>
<form action="feedback_categories" method="post">
<?php
    //Error Session leeren
    $_SESSION['error'] = NULL;
    $feedbackcategories = getAllFeedbackCategories();
    $start = 1;
    if(!empty($feedbackcategories)){
        //Den Startpunkt erhöhen wenn schon Fragen ausgefüllt wurden
        while($row = mysqli_fetch_assoc($feedbackcategories)){
            $data = getUserFeedbackArrayByFeedbackCategoryID($row['id_feedbackkategorie'], getUserIDByUsername($_SESSION['benutzer_app']));
            if(!empty($data)){
                if($data['feedbackkategorie_id'] == $row['id_feedbackkategorie']){
                    $start++;
                }
            }
        }
    }
    else{
        $start = 1;
    }
    //Wenn schon eine Feedbackfrage beantwortet wurde
    if($start != 1){
        echo '
            <p class="p_untertitel">Mit dem Knopf unten kommst du zur begonnenen Umfrage. Du kannst genau dort fortfahren, wo du das letzte mal aufgehört hast.</p>
            <input class="button_weiter" type="submit" name="submit_btn" value="Fortfahren"/>
        ';
    }
    else{
        echo '
            <p class="p_untertitel">Mit dem Knopf unten kommst du zur Umfrage. Am besten beantwortest du sie gerade an einem Stück.</p>
            <input class="button_weiter" type="submit" name="submit_btn" value="Starten"/>
        ';
    }
    $array = array();
    array_push($array, "feedback_categories", "validate_feedback_categories");
    removeSessionInvalid($array);
    echo '
        <input type="hidden" name="startid" value="'.$start.'"/>
    ';
?>
</form>
