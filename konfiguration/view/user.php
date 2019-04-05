<div class="div_main">
    <?php
        //Error Session leeren
        $_SESSION['error'] = NULL;
        if($_SESSION['no_file'] == 1){
            $alert = "Kein Valides File ausgewählt";
            echo "<script type='text/javascript'>alert('$alert');</script>";
        }
        $_SESSION['url'] = NULL;
        //Stack ausgeben
        echo '<p id="p_stack">'.$_SESSION['stack'].'</p>';
    ?>
    <div class="div_flex">
        <a href="user_add">
            <div class="einstellungsbox">
                <img class="img_einstellungsbox" src="./image/user_add.png" alt="benutzer/hinzufügenbutton">
                <p class="p_einstellungsbox">
                    Benutzer hinzufügen
                </p>
            </div>
        </a>
        <a href="user_edit_choice">
            <div class="einstellungsbox">
                <img class="img_einstellungsbox" src="./image/user_edit.png" alt="benutzer/einstellungsrad">
                <p class="p_einstellungsbox">
                    Benutzer bearbeiten
                </p>
            </div>
        </a>
        <form action="validate_user_import" method="post" enctype="multipart/form-data">
            <button type="submit" class="btn_einstellungsbox">
                <img class="img_einstellungsbox" src="./image/import.png" alt="benutzer/import">
                <p class="p_einstellungsbutton">
                    Benutzer importieren
                </p>
            <input type="file" name="csv_file" class="file_input_csv" accept=".csv">
            </button>
        </form>
    </div>
    <form action="stack" method="post">
        <input class="button_zurück_stack" type="submit" name="submit_btn" value="Zurück">
    </form>
</div>