<?php
    //Fehlermeldung löschen
    $_SESSION['error'] = NULL;
    //Session zerstören
    session_unset();
    session_destroy();
    header('Location: home');
?>