<h2>Einstellungen</h2>
<p class="p_untertitel">Hier kannst du dein Passwort ändern.</p>
<?php
	require_once('error.php');
?>
<form action="validate_einstellungen" method="post">
	<div id="div_form">
		<p class="p_form">Altes Passwort</p>
		<input class="forms_login" type="password" name="passwort_alt"/>
		<br>
		<p class="p_form">Neues Passwort</p>
		<input class="forms_login" type="password" name="passwort_neu"/>
        <br>
		<p class="p_form">Neues Passwort wiederholen</p>
		<input class="forms_login" type="password" name="passwort_neu_repeat"/>
        <br>
        <div class="separation_line"></div>
		<input class="button_weiter" name="submit_btn" type="submit" value="Ändern"/>
		<input class="button_zurück" name="submit_btn" type="submit" value="Zurück"/>
	</div>
</form>