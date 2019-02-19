<?php
    //Fehlermeldung löschen
    $_SESSION['error'] = NULL;
    //Wenn der button Weiter oder Abschliessen geklickt wurde
    if($_POST['submit_btn'] == "Weiter" | $_POST['submit_btn'] == "Abschliessen"){
        if(!empty($_POST['options'])){
            if(!empty($_POST['bemerkung'])){
                //specialchars validieren
                $bemerkung = htmlspecialchars($_POST['bemerkung']);
                if(strlen($bemerkung) <= 500){
                    insertUserFeedback(getUserIDByUsername($_SESSION['benutzer_app']), $_POST['feedbackid'], $_POST['options'], $bemerkung);
                    //Wenn es die letzte Feedbackfrage gewesen ist
                    if($_POST['submit_btn'] == "Abschliessen"){
                        header('Location: home');
                    }
                    else{
                        $_SESSION['startid'] = intval($_POST['startid']);
                        header('Location: feedback_categories');
                    }
                }
                else{
                    $_SESSION['error'] = "Deine Bemerkung ist zu lang! Max. 500 Zeichen.";
                    $_SESSION['startid'] = (intval($_POST['startid']) - 1);
                    header('Location: feedback_categories');
                }
            }
            else{
                insertUserFeedback(getUserIDByUsername($_SESSION['benutzer_app']), $_POST['feedbackid'], $_POST['options'], NULL);
                if($_POST['submit_btn'] == "Abschliessen"){
                    header('Location: home');
                }
                else{
                    $_SESSION['startid'] = intval($_POST['startid']);
                    header('Location: feedback_categories');
                }
            }
        }
        //Wenn keine Antwort angegeben wurde
        else{
            $_SESSION['error'] = "Es wurde keine Antwort angegeben!";
            //Die vordere Frage noch einmal laden
            $_SESSION['startid'] = (intval($_POST['startid']) - 1);
            header('Location: feedback_categories'); 
        }
    }
    else{
        header('Location: home');
    }
?>