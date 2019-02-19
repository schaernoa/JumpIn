<div class="div_main">
    <?php
        //Error Session leeren
        $_SESSION['error'] = NULL;
        //Stack ausgeben
        echo '<p id="p_stack">'.$_SESSION['stack'].'</p>';
    ?>
    <div class="div_flex">
        <a href="aktivitaet">
            <div class="einstellungsbox">
                <img class="img_einstellungsbox" src="./image/aktivitaet.png" alt="">
                <p class="p_einstellungsbox">
                    Aktivität
                </p>
            </div>
        </a>
        <a href="aktivitaetblock">
            <div class="einstellungsbox">
                <img class="img_einstellungsbox" src="./image/aktivitaetblock.png" alt="kalender/hinzufügenbutton">
                <p class="p_einstellungsbox">
                    Aktivitätsblock
                </p>
            </div>
        </a>
        <a href="aktivitaetsart">
            <div class="einstellungsbox">
                <img class="img_einstellungsbox" src="./image/aktivitaetsart.png" alt="kalender/einstellungsrad">
                <p class="p_einstellungsbox">
                    Aktivitätsart
                </p>
            </div>
        </a>
    </div>
    <form action="stack" method="post">
        <input class="button_zurück_stack" type="submit" name="submit_btn" value="Zurück">
    </form>
</div>