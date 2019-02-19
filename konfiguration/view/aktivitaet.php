<div class="div_main">
    <?php
        //Error Session leeren
        $_SESSION['error'] = NULL;
        //Stack ausgeben
        echo '<p id="p_stack">'.$_SESSION['stack'].'</p>';
    ?>
    <div class="div_flex">
        <a href="aktivitaet_add">
            <div class="einstellungsbox">
                <img class="img_einstellungsbox" src="./image/aktivitaet_add.png" alt="kalender/hinzufügenbutton">
                <p class="p_einstellungsbox">
                    Aktivität hinzufügen
                </p>
            </div>
        </a>
        <a href="aktivitaet_edit_choice">
            <div class="einstellungsbox">
                <img class="img_einstellungsbox" src="./image/aktivitaet_edit.png" alt="kalender/einstellungsrad">
                <p class="p_einstellungsbox">
                    Aktivität bearbeiten
                </p>
            </div>
        </a>
    </div>
    <form action="stack" method="post">
        <input class="button_zurück_stack" type="submit" name="submit_btn" value="Zurück">
    </form>
</div>