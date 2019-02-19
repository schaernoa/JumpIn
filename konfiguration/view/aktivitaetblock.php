<div class="div_main">
    <?php
        //Error Session leeren
        $_SESSION['error'] = NULL;
        //Stack ausgeben
        echo '<p id="p_stack">'.$_SESSION['stack'].'</p>';
    ?>
    <div class="div_flex">
        <a href="aktivitaetblock_add">
            <div class="einstellungsbox">
                <img class="img_einstellungsbox" src="./image/aktivitaetblock_add.png" alt="fussball/hinzufügenbutton">
                <p class="p_einstellungsbox">
                    Aktivitätsblock hinzufügen
                </p>
            </div>
        </a>
        <a href="aktivitaetblock_edit_choice">
            <div class="einstellungsbox">
                <img class="img_einstellungsbox" src="./image/aktivitaetblock_edit.png" alt="fussball/einstellungsrad">
                <p class="p_einstellungsbox">
                    Aktivitätsblock bearbeiten
                </p>
            </div>
        </a>
    </div>
    <form action="stack" method="post">
        <input class="button_zurück_stack" type="submit" name="submit_btn" value="Zurück">
    </form>
</div>