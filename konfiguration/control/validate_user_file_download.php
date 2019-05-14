<?php
    $log = "import_log.txt";
    $users = "newusers_log.txt";
    /*Realtive Pfadangabe beim letzten Parent Directory nur "./"
    Sonst immer "../" um eine Ebene nach innen zu navigieren*/
    $logfile = '../../.././jumpin_log/import_log.txt';
    $usersfile = '../../.././jumpin_log/newusers_log.txt';

    if($_POST['submit_btn'] == "Download New Users"){
        $type = filetype($usersfile);
        $file = $users;
        $filename = $usersfile;
    }
    else if($_POST['submit_btn'] == "Download Log-File"){
        $type = filetype($logfile);
        $file = $log;
        $filename = $logfile;
    }
    header("Content-type: $type");
    header("Content-Disposition: attachment; filename=$file");
    readfile("$filename");
    exit();
?> 