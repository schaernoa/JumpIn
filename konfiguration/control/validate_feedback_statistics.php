<?php
    //Error Session leeren
    $_SESSION['error'] = NULL;
    //Validierungsvariable setzen
    $validated = false;

    //Wenn Anzeigen geklickt wurde
    if($_POST['submit_btn'] == "Anzeigen"){
        //Wenn alle Felder ausgefüllt wurden
        if(!empty($_POST['username'])){
            //hole alle Benutzer
            $user = getAllUser();
            //Für jeden Benutzer
            while($row = mysqli_fetch_assoc($user)){
                //Wenn der benutzer nicht Admin ist
                if(strtolower($row['benutzername']) != "admin"){
                    //Wenn der benutzername mit dem Eingegebenen übereinstimmt
                    if($row['benutzername'] == $_POST['username']){
                        //Eingaben richtig
                        $validated = true;
                    }
                }
            }
        }
        //Wenn Eingaben richtig
        if($validated){
            //Den benutzernamen in einer Session speichern
            $_SESSION['feedback_user'] = $_POST['username'];
            header('Location: feedback_statistics_user');
        }
        else{
            $_SESSION['error'] = "Dieser Benutzername existiert nicht!";
            header('Location: feedback_statistics');
        }   
    }
    //Wenn Zurück geklickt wurde
    else if($_POST['submit_btn'] == "Zurück"){
        header('Location: feedback');
    }
    else{
        header('Location: home');
    }
?>