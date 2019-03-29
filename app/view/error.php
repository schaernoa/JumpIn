<?php
	//Wenn es eine Fehlermeldung anzuzeigen gibt
	if(!empty($_SESSION['error'])){

		if($_SESSION['error'] == "changed"){
			$message = "Passwort geändert";
			echo "<script type='text/javascript'>alert('$message');</script>";
		}
		else{
			echo '
				<p class="p_error">'.$_SESSION['error'].'</p>
			';
		}
	}
?>