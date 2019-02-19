<?php
    //error session leeren
    $_SESSION['error'] = NULL;
	oneStackBack();
    //funktion um ein file im stack zurückzugehen
	function oneStackBack(){
        //stack aus der session holen
        $stackstring = $_SESSION['stack'];
        //stack bei jedem / trennen und daten dann in array stecken
        $stackarray = explode("/",$stackstring);
        //das letzte file im array laden
		header('Location: '.$stackarray[count($stackarray) - 4].'');
    }
?>