<div class="div_main">
    <?php
        //Error Session leeren
        $_SESSION['error'] = NULL;
        //Stack ausgeben
        echo '<p id="p_stack">'.$_SESSION['stack'].'</p>';
    ?>
    <div class="div_flex">
        <a href="steckbrief_add">
            <div class="einstellungsbox">
                <img class="img_einstellungsbox" src="./image/group_add.png" alt="steckbrief/hinzufügenbutton">
                <p class="p_einstellungsbox">
                    Steckbriefkat. hinzufügen
                </p>
            </div>
        </a>
        <a href="steckbrief_edit_choice">
            <div class="einstellungsbox">
                <img class="img_einstellungsbox" src="./image/group_edit.png" alt="steckbriefkategorie/einstellungsrad">
                <p class="p_einstellungsbox">
                    Steckbriefkat. bearbeiten
                </p>
            </div>
        </a>
    </div>
    <form action="stack" method="post">
        <input class="button_zurück_stack" type="submit" name="submit_btn" value="Zurück">
    </form>
</div>