<?php
	//File um alles andere zu integrieren
	//builder integrieren
	include_once 'control/builder.php';
	//URI holen und auf das relevante trennen
	$temp = trim($_SERVER['REQUEST_URI'], '/');
	$url = explode('/', $temp);
	//Fehlermeldungen oder Warnungen die ausgegeben werden sollen
	error_reporting(E_ALL & ~E_NOTICE);
	//Session starten wenn keine besteht oder eine obenbehalten wenn eine besteht
	session_start();

	//Wenn der relevante Teil der URi nicht leer ist
	if(!empty($url[2])){
		$url[2] = strtolower($url[2]);
		//zwischen den möglichen Fällen auswählen
		switch($url[2]){
			case 'validate_anmelden':
				build('validate_anmelden.php');
				break;
			case 'home':
				build('./view/home.php');
				break;
			case 'stack':
				build('stack.php');
				break;
			case 'logout':
				build('logout.php');
				break;
			case 'allgemein':
				build('./view/allgemein.php');
				break;
			case 'aktivitaeten':
				build('./view/aktivitaeten.php');
				break;

			case 'aktivitaetblock':
				build('./view/aktivitaetblock.php');
				break;
			case 'aktivitaetblock_add':
				build('./view/aktivitaetblock_add.php');
				break;
			case 'validate_aktivitaetblock_add':
				build('validate_aktivitaetblock_add.php');
				break;
			case 'aktivitaetblock_edit_choice':
				build('./view/aktivitaetblock_edit_choice.php');
				break;
			case 'validate_aktivitaetblock_edit_choice':
				build('validate_aktivitaetblock_edit_choice.php');
				break;
			case 'aktivitaetblock_edit':
				build('./view/aktivitaetblock_edit.php');
				break;
			case 'validate_aktivitaetblock_edit':
				build('validate_aktivitaetblock_edit.php');
				break;

			case 'aktivitaetsart':
				build('./view/aktivitaetsart.php');
				break;
			case 'aktivitaetsart_add':
				build('./view/aktivitaetsart_add.php');
				break;
			case 'aktivitaetsart_edit_choice':
				build('./view/aktivitaetsart_edit_choice.php');
				break;
			case 'aktivitaetsart_edit':
				build('./view/aktivitaetsart_edit.php');
				break;
			case 'validate_aktivitaetsart_add':
				build('validate_aktivitaetsart_add.php');
				break;
			case 'validate_aktivitaetsart_edit':
				build('validate_aktivitaetsart_edit.php');
				break;
			case 'validate_aktivitaetsart_edit_choice':
				build('validate_aktivitaetsart_edit_choice.php');
				break;

			case 'aktivitaet':
				build('./view/aktivitaet.php');
				break;
			case 'aktivitaet_add':
				build('./view/aktivitaet_add.php');
				break;
			case 'aktivitaet_edit_choice':
				build('./view/aktivitaet_edit_choice.php');
				break;
			case 'aktivitaet_edit':
				build('./view/aktivitaet_edit.php');
				break;
			case 'validate_aktivitaet_add':
				build('validate_aktivitaet_add.php');
				break;
			case 'aktivitaet_add_einschreiben':
				build('./view/aktivitaet_add_einschreiben.php');
				break;
			case 'validate_aktivitaet_add_einschreiben':
				build('validate_aktivitaet_add_einschreiben.php');
				break;

			case 'aktivitaet_add_group':
				build('./view/aktivitaet_add_group.php');
				break;
			case 'validate_aktivitaet_add_group':
				build('validate_aktivitaet_add_group.php');
				break;
			case 'validate_aktivitaet_edit_choice':
				build('validate_aktivitaet_edit_choice.php');
				break;
			case 'validate_aktivitaet_edit':
				build('validate_aktivitaet_edit.php');
				break;
			case 'aktivitaet_edit_einschreiben':
				build('./view/aktivitaet_edit_einschreiben.php');
				break;
			case 'aktivitaet_edit_group':
				build('./view/aktivitaet_edit_group.php');
				break;
			case 'validate_aktivitaet_edit_einschreiben':
				build('validate_aktivitaet_edit_einschreiben.php');
				break;
			case 'validate_aktivitaet_edit_group':
				build('validate_aktivitaet_edit_group.php');
				break;

			case 'steckbrief':
				build('./view/steckbrief.php');
				break;
			case 'steckbrief_add':
				build('./view/steckbrief_add.php');
				break;
			case 'steckbrief_edit_choice':
				build('./view/steckbrief_edit_choice.php');
				break;
			case 'steckbrief_edit':
				build('./view/steckbrief_edit.php');
				break;
			case 'validate_steckbrief_edit_choice':
				build('validate_steckbrief_edit_choice.php');
				break;
			case 'validate_steckbrief_add':
				build('validate_steckbrief_add.php');
				break;
			case 'validate_steckbrief_edit':
				build('validate_steckbrief_edit.php');
				break;

			case 'notfallkarte':
				build('./view/notfallkarte.php');
				break;
			case 'notfallkarte_add':
				build('./view/notfallkarte_add.php');
				break;
			case 'notfallkarte_edit_choice':
				build('./view/notfallkarte_edit_choice.php');
				break;
			case 'notfallkarte_edit':
				build('./view/notfallkarte_edit.php');
				break;
			case 'validate_notfallkarte_edit_choice':
				build('validate_notfallkarte_edit_choice.php');
				break;
			case 'validate_notfallkarte_add':
				build('validate_notfallkarte_add.php');
				break;
			case 'validate_notfallkarte_edit':
				build('validate_notfallkarte_edit.php');
				break;

			case 'feedback':
				build('./view/feedback.php');
				break;
			case 'feedback_add':
				build('./view/feedback_add.php');
				break;
			case 'feedback_add_optionen':
				build('./view/feedback_add_optionen.php');
				break;
			case 'feedback_edit_choice':
				build('./view/feedback_edit_choice.php');
				break;
			case 'feedback_edit':
				build('./view/feedback_edit.php');
				break;
			case 'feedback_edit_optionen':
				build('./view/feedback_edit_optionen.php');
				break;
			case 'validate_feedback_edit_choice':
				build('validate_feedback_edit_choice.php');
				break;
			case 'validate_feedback_add':
				build('validate_feedback_add.php');
				break;
			case 'validate_feedback_add_optionen':
				build('validate_feedback_add_optionen.php');
				break;
			case 'validate_feedback_edit':
				build('validate_feedback_edit.php');
				break;
			case 'validate_feedback_edit_optionen':
				build('validate_feedback_edit_optionen.php');
				break;
			case 'feedback_statistics':
				build('./view/feedback_statistics.php');
				break;
			case 'validate_feedback_statistics':
				build('validate_feedback_statistics.php');
				break;
			case 'feedback_statistics_user':
				build('./view/feedback_statistics_user.php');
				break;
			case 'validate_feedback_statistics_user':
				build('validate_feedback_statistics_user.php');
				break;
			case 'user':
				build('./view/user.php');
				break;
			case 'user_add':
				build('./view/user_add.php');
				break;
			case 'validate_user_add':
				build('validate_user_add.php');
				break;
			case 'user_group_add':
				build('./view/user_group_add.php');
				break;
			case 'validate_user_group_add':
				build('validate_user_group_add.php');
				break;
			case 'user_edit_choice':
				build('./view/user_edit_choice.php');
				break;
			case 'validate_user_edit_choice':
				build('validate_user_edit_choice.php');
				break;
			case 'validate_user_edit_choice':
				build('validate_user_edit_choice.php');
				break;
			case 'user_edit':
				build('./view/user_edit.php');
				break;
			case 'user_group_edit':
				build('./view/user_group_edit.php');
				break;
			case 'validate_user_edit':
				build('validate_user_edit.php');
				break;
			case 'validate_user_group_edit':
				build('validate_user_group_edit.php');
				break;

			case 'group':
				build('./view/group.php');
				break;
			case 'group_add':
				build('./view/group_add.php');
				break;
			case 'group_edit_choice':
				build('./view/group_edit_choice.php');
				break;
			case 'group_edit':
				build('./view/group_edit.php');
				break;
			case 'validate_group_edit_choice':
				build('validate_group_edit_choice.php');
				break;
			case 'validate_group_add':
				build('validate_group_add.php');
				break;
			case 'validate_group_edit':
				build('validate_group_edit.php');
				break;

			case 'reset':
				build('./view/reset.php');
				break;
			case 'validate_reset':
				build('validate_reset.php');
				break;
			default:
				build('./view/login.php');
				break;
		}
	}
	//Wenn kein relevanter Teuil angegeben wurde
	else{
		build('./view/login.php');
	}
?>
