<div class="div_main">
    <?php
        //Error Session leeren
        $_SESSION['error'] = NULL;
        //Stack ausgeben
        echo '<p id="p_stack">'.$_SESSION['stack'].'</p>';
    ?>
    <div class="div_flex">
        <a href="user">
            <div class="einstellungsbox">
                <img class="img_einstellungsbox" src="./image/user.png" alt="kopf">
                <p class="p_einstellungsbox">
                    Benutzer
                </p>
            </div>
        </a>
        <a href="group">
            <div class="einstellungsbox">
                <img class="img_einstellungsbox" src="./image/steckbrief.png" alt="gruppe">
                <p class="p_einstellungsbox">
                    Gruppe
                </p>
            </div>
        </a>
        <a href="reset">
            <div class="einstellungsbox">
                <img class="img_einstellungsbox" src="./image/reset.png" alt="gruppe">
                <p class="p_einstellungsbox">
                    Jump-In zurücksetzen
                </p>
            </div>
        </a>
    </div>
    <form action="stack" method="post">
        <input class="button_zurück_stack" type="submit" name="submit_btn" value="Zurück">
    </form>
</div>