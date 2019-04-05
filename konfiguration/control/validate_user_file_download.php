<?php
    $log = "import_log.txt";
    $users = "newusers_log.txt";
    $logfile = './log/import_log.txt';
    $usersfile = './log/newusers_log.txt';

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