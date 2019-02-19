<?php
	//Wenn die Error Session nicht leer ist
	if(!empty($_SESSION['error'])){
		//Die Fehlermeldung in Rot ausgeben
		echo '
			<p class="p_error">'.$_SESSION['error'].'</p>
		';
	}
?>