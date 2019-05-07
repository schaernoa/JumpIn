<div class="div_main">
    <?php
        //Error Session leeren
        $_SESSION['error'] = NULL;
        $_SESSION['users_added'] = 'done';
        //Stack ausgeben
        echo '<p id="p_stack">'.$_SESSION['stack'].'</p>';
    ?>
    <div class="div_form">
        <p class="p_form_title">
            Import Resultate
        </p>
        <?php
            echo '<p class="p_form">Anzahl neue User: '.$_SESSION['success_user_import'].'</p>';
            echo '<p class="p_form">Anzahl Fehler: '.$_SESSION['error_user_import'].'</p>';
            if(count($_SESSION['invalid_usernames']) != 0){
                echo '<p class="p_form">Folgende Usernamen sind bereits vergeben:</p>';
                foreach($_SESSION['invalid_usernames'] as $username){
                    echo '<p class="p_form_username">'.$username.'</p>';
                }
            }
        ?>
        <form action="validate_user_file_download" method="post">
            <input class="button_file_download" type="submit" name="submit_btn" value="Download New Users"/>
            <input class="button_file_download" type="submit" name="submit_btn" value="Download Log-File"/>
        </form>

        <form action="stack" method="post">
            <input class="button_zurück_choice" type="submit" name="submit_btn" value="Zurück">
        </form>
    </div>
</div>