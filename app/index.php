<?php
	//In dieses File wird alles zusammengetragen
	//builder integrieren
	include_once 'control/builder.php';
	//Die URI holen und so abschneiden, dass man das geladene File herauslesen kann
	$temp = trim($_SERVER['REQUEST_URI'], '/');
	$url = explode('/', $temp);
	//etliche Fehler und Warnungen werden im Broser ausgegeben
	error_reporting(E_ALL & ~E_NOTICE);
	//start eine neue session oder lasse die alte
	session_start(); 

	//wenn das zu ladene File überhaupt besteht
	if(!empty($url[2])){
		$url[2] = strtolower($url[2]);
		//für alle möglichen files ein case
		switch($url[2]){
			case 'login':
				build('./view/login.php');
				break;
			case 'validate_login':
				build('validate_login.php');
				break;
			case 'validate_logout':
				build('validate_logout.php');
				break;
			case 'notfall':
				build('./view/notfall.php');
				break;
			case 'steckbrief':
				build('./view/steckbrief.php');
				break;
			case 'steckbrief_choice':
				build('./view/steckbrief_choice.php');
				break;
			case 'steckbrief_add':
				build('./view/steckbrief_add.php');
				break;
			case 'validate_steckbrief_add':
				build('validate_steckbrief_add.php');
				break;
			case 'steckbrief_kategorie_add':
				build('./view/steckbrief_kategorie_add.php');
				break;
			case 'validate_steckbrief_kategorie_add':
				build('validate_steckbrief_kategorie_add.php');
				break;
			case 'steckbrief_view':
				build('./view/steckbrief_view.php');
				break;
			case 'validate_steckbrief_view':
				build('validate_steckbrief_view.php');
				break;
			case 'validate_steckbrief_loeschen':
				build('validate_steckbrief_loeschen.php');
				break;
			case 'validate_steckbrief_order':
				build('validate_steckbrief_order.php');
				break;
			case 'wochenplan':
				build('./view/wochenplan.php');
				break;
			case 'wochenplan_view':
				build('./view/wochenplan_view.php');
				break;
			case 'validate_wochenplan_view':
				build('validate_wochenplan_view.php');
				break;
			case 'einschreiben_choice':
				build('./view/einschreiben_choice.php');
				break;
			case 'einschreiben_choice_aktivitaeten':
				build('./view/einschreiben_choice_aktivitaeten.php');
				break;
			case 'validate_einschreiben_choice_aktivitaeten':
				build('validate_einschreiben_choice_aktivitaeten.php');
				break;
			case 'einschreiben':
				build('./view/einschreiben.php');
				break;
			case 'validate_einschreiben':
				build('validate_einschreiben.php');
				break;
			case 'feedback':
				build('./view/feedback.php');
				break;
			case 'feedback_categories':
				build('./view/feedback_categories.php');
				break;
			case 'validate_feedback_categories':
				build('validate_feedback_categories.php');
				break;
			case 'validate_wochenplan_steckbrief_view':
				build('validate_wochenplan_steckbrief_view.php');
				break;
			default:
				build('./view/home.php');
				break;
		}
	}
	//ansonsten home aufrufen
	else{
		build('./view/home.php');
	}
?>