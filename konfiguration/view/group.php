<div class="div_main">
    <?php
        //Error Session leeren
        $_SESSION['error'] = NULL;
        //Stack ausgeben
        echo '<p id="p_stack">'.$_SESSION['stack'].'</p>';
    ?>
    <div class="div_flex">
        <a href="group_add">
            <div class="einstellungsbox">
                <img class="img_einstellungsbox" src="./image/group_add.png" alt="gruppe/hinzufügenbutton">
                <p class="p_einstellungsbox">
                    Gruppe hinzufügen
                </p>
            </div>
        </a>
        <a href="group_edit_choice">
            <div class="einstellungsbox">
                <img class="img_einstellungsbox" src="./image/group_edit.png" alt="gruppe/einstellungsrad">
                <p class="p_einstellungsbox">
                    Gruppe bearbeiten
                </p>
            </div>
        </a>
    </div>
    <form action="stack" method="post">
        <input class="button_zurück_stack" type="submit" name="submit_btn" value="Zurück">
    </form>
</div>