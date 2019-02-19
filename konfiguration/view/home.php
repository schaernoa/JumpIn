<div class="div_main">
    <?php
        //Error Session leeren
        $_SESSION['error'] = NULL;
        //Stack ausgeben
        echo '<p id="p_stack">'.$_SESSION['stack'].'</p>';
    ?>
    <div class="div_flex">
        <a href="allgemein">
            <div class="einstellungsbox">
                <img class="img_einstellungsbox" src="./image/allgemein.png" alt="einstellungsrad">
                <p class="p_einstellungsbox">
                    Allgemein
                </p>
            </div>
        </a>
        <a href="aktivitaeten">
            <div class="einstellungsbox">
                <img class="img_einstellungsbox" src="./image/aktivitaetblock.png" alt="fussball">
                <p class="p_einstellungsbox">
                    Aktivitäten
                </p>
            </div>
        </a>
        <a href="steckbrief">
            <div class="einstellungsbox">
                <img class="img_einstellungsbox" src="./image/steckbrief.png" alt="köpfe">
                <p class="p_einstellungsbox">
                    Steckbrief kategorie
                </p>
            </div>
        </a>
        <a href="notfallkarte">
            <div class="einstellungsbox">
                <img class="img_einstellungsbox" src="./image/notfallkarte.png" alt="krankenwagen">
                <p class="p_einstellungsbox">
                    Notfallkarte
                </p>
            </div>
        </a>
        <a href="feedback">
            <div class="einstellungsbox">
                <img class="img_einstellungsbox" src="./image/feedback.png" alt="sprechblase">
                <p class="p_einstellungsbox">
                    Feedback
                </p>
            </div>
        </a>
    </div>
</div>