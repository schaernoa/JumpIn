<?php
    //error session leeren
    $_SESSION['error'] = NULL;
    //session des benutzers zerstören -> logout
    session_unset();
    session_destroy();
    //weiterleiten nach header.php
    header('Location: login');
?>