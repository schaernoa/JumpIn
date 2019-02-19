<div class="div_main">
    <?php
        //Error Session leeren
        $_SESSION['error'] = NULL;
        //Stack ausgeben
        echo '<p id="p_stack">'.$_SESSION['stack'].'</p>';
    ?>
    <div class="div_form">
        <p class="p_form_title">
            Jump-In zurücksetzen
        </p>
        <p class="p_content">
            Bei einem Reset von einem Jump-In passiert folgendes:
        </p>
        <ul class="p_content">
            <li>Alle Gruppen ausser die Gruppen Admin und Coach werden gelöscht</li>
            <li>Alle Benutzer welche nicht der Gruppe Admin oder Coach zugeteilt sind werden gelöscht</li>
            <li>Alle Aktivitäten, alle Aktivitätblöcke und alle Einschreibungen werden gelöscht</li>
            <li>Alle Feedbackbögen werden gelöscht</li>
            <li>Alle nicht obligatorischen Steckbriefkategorien und alle Steckbriefe werden gelöscht</li>
        </ul>
        <form action="validate_reset" method="post">
            <input class="button_zurück" type="submit" name="submit_btn" value="Zurück">
        </form>
        <button id="modal_reset_button" class="button_weiter">Reset</button>
    </div>
</div>
<div id="modal_reset" class="modal">
    <div class="modal_reset_content">
        <span class="modal_reset_close">&times;</span>
        <p>
            Bist du dir allen erwähnten <b>Konsequenzen bewusst</b>, und willst das JumpIn trotzdem <b>reseten?</b>
        </p>
        <button id="button_abbrechen" class="button_zurück_modal">Abbrechen</button>
        <form action="validate_reset" method="post">
            <input class="button_weiter" type="submit" name="submit_btn" value="Reset"/>
        </form>
    </div>
</div>
<script>
    //Javascript für Reminder auszugeben
    var modal = document.getElementById('modal_reset');
    var btn = document.getElementById("modal_reset_button");
    var btn2 = document.getElementById("button_abbrechen");
    var span = document.getElementsByClassName("modal_reset_close")[0];

    btn.onclick = function() {
        modal.style.display = "block";
    }
    span.onclick = function() {
        modal.style.display = "none";
    }
    btn2.onclick = function() {
        modal.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    } 
</script>