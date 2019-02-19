<img id="img_login" src="./image/user.png" alt="usericon">
<form action="validate_anmelden" method="post">
	<div id="div_login">
		<?php
			//Fehlercode integrieren
			require_once('error.php');
		?>
		<p class="p_login">Benutzername</p>
		<input class="forms_login" type="text" name="benutzername" required/>
		<br>
		<p class="p_login">Passwort</p>
		<input class="forms_login" type="password" name="passwort" required/>
		<br>
		<input id="button_login" type="submit" name="submit_btn" value="Login"/>
	</div>
</form>