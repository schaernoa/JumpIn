<div class="div_main">
    <?php
        //Error Session leeren
        $_SESSION['error'] = NULL;
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
    </div>
    <form action="stack" method="post">
        <input class="button_zurück_stack" type="submit" name="submit_btn" value="Zurück">
    </form>
</div>