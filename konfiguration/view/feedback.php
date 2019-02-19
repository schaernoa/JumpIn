<div class="div_main">
    <?php
        //Error Session leeren
        $_SESSION['error'] = NULL;
        //Stack ausgeben
        echo '<p id="p_stack">'.$_SESSION['stack'].'</p>';
    ?>
    <div class="div_flex">
        <a href="feedback_add">
            <div class="einstellungsbox">
                <img class="img_einstellungsbox" src="./image/feedback_add.png" alt="Sprechblase mit Hinzufügen Button">
                <p class="p_einstellungsbox">
                    Feedbackkat. hinzufügen
                </p>
            </div>
        </a>
        <a href="feedback_edit_choice">
            <div class="einstellungsbox">
                <img class="img_einstellungsbox" src="./image/feedback_edit.png" alt="Sprechblase mit Einstellungsrad">
                <p class="p_einstellungsbox">
                    Feedbackkat. bearbeiten
                </p>
            </div>
        </a>
        <a href="feedback_statistics">
            <div class="einstellungsbox">
                <img class="img_einstellungsbox" src="./image/feedback_statistics.png" alt="Statistik Icon">
                <p class="p_einstellungsbox">
                    Feedback Statistik
                </p>
            </div>
        </a>
    </div>
    <form action="stack" method="post">
        <input class="button_zurück_stack" type="submit" name="submit_btn" value="Zurück">
    </form>
</div>