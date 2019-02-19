<h2>Erstelle jetzt deinen Steckbrief!</h2>
<?php
    //Hole den Fehlermeldung Code
    require_once('error.php');
?>
<form action="validate_steckbrief_add" method="POST" enctype="multipart/form-data">
    <p class="p_form">Bild von dir</p>
    <input class="forms_file" type="file" accept=".jpg, .jpeg, .png" name="bild"/>
<?php
    $steckbriefkategorien = getCharacteristicsCategoryByObligation();
    //Für alle Steckbriefkategorien die obligatorisch sind
    while($row = mysqli_fetch_assoc($steckbriefkategorien)){
        //Wenn es ein Einzeiler ist
        if($row['einzeiler'] == "1"){
            echo '
                <p class="p_form">'.$row['name'].'</p>
                <input class="forms_login" type="text" name="'.$row['id_steckbriefkategorie'].'"/>
                <input type="hidden" name="steckbrief[]" value="'.$row['id_steckbriefkategorie'].'"/>
                <br>
            ';
        }
        else{
            echo '
                <p class="p_form">'.$row['name'].'</p>
                <textarea class="forms_textarea" name="'.$row['id_steckbriefkategorie'].'" maxlength="300"></textarea>
                <input type="hidden" name="steckbrief[]" value="'.$row['id_steckbriefkategorie'].'"/>
                <br>
            ';
        }
    }
?>
    <input class="button_weiter" type="submit" name="submit_btn" value="Erstellen"/>
    <input class="button_zurück" type="submit" name="submit_btn" value="Zurück"/>
</form>