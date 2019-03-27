<h2>Einloggen</h2>
<p class="p_untertitel">Melde dich mit deinen erhaltenen Benutzerdaten an.</p>
<?php
	require_once('error.php');
	$benutzername = $_SESSION['error_login'];
?>
<form action="validate_login" method="post">
	<div id="div_form">
		<p class="p_form">Benutzername</p>
		<input class="forms_login" id="benutzername" type="text" name="benutzername" value="<?php if(isset($benutzername)) {echo $benutzername;} ?>"/>
		<br>
		<p class="p_form">Passwort</p>
		<input class="forms_login" type="password" name="passwort" value="<?php if(isset($passwort)) {echo $passwort;} ?>"/>
        <br>
        <div class="separation_line"></div>
		<input class="button_weiter" name="submit_btn" type="submit" value="Login"/>
		<input class="button_zurück" name="submit_btn" type="submit" value="Abbrechen"/>
	</div>
</form>

<script type="text/javascript">
	$("#benutzername").focus();
</script>