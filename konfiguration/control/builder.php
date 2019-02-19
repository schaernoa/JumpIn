<?php
	//Methode für einen bestimmten main abschnitt zu laden
	//$path ist der pfad des files welches geladen werden soll
    function build($path){
?>
        <!DOCTYPE html>
		<html>
			<head>
				<title>Jump-In Konfiguration</title>
				<link rel="stylesheet" href="./css/style.css">
				<meta charset="UTF-8">
				<meta name="viewport"
					content="width=device-width, initial-scale=1, maximum-scale=1"/>
			</head>
			<body>
				<?php
					//es wird immer der selbe header genutzt
					require_once './view/header.php'; 
				?> 
				<main>
					<?php
						/*wenn der benutzer eine session bestehen hat
						und auf die login seite kommen will,
						kommt er stattdessen auf die home seite */
						if ($path == './view/login.php') {
							if($_SESSION['benutzer']){
								$path = './view/home.php';
								setStack($path);
							}
						}
						/*wenn der benutzer auf die validiere anmelden seite kommen will
						lädt das vorgsehene Ziel*/
						elseif ($path == 'validate_anmelden.php') {}
						else {
							/*wenn der benutzer keine session hat
							kommt er in jedem fall auf die login seite*/
							if(!$_SESSION['benutzer']){
								$path = './view/login.php';
							}
							//ansonsten wird das vorgesehene file in den stack geschrieben
							else{
								setStack($path);
							}
						}
						//lädt das file hinein
						require_once $path; 
					?> 
				</main>
			</body>
		</html>
		<?php	 
	}

	//Methode für das geladene file in den stack zu schreiben
	//$path das geladene File
    function setStack($path){
		//holt den vorherigen stack aus der sessionvariable
        $stackstring = $_SESSION['stack'];
		$stackarray = explode("/",$stackstring);
		$finalstringbefore = $stackarray[count($stackarray) - 2];

		//teilt den pfad des geladenen files
		//nur noch auf das benötigte zu
		$patharray = explode(".",$path);
		$pathstring = $patharray[count($patharray) - 2];
		$patharray2 = explode("/",$pathstring);
		$finalstring = $patharray2[count($patharray2) - 1];

		//wenn zuvor schon etwas im stack war
		if($finalstringbefore != NULL){
			//wenn das zu ladende file zuvor schon im stack war
			if(in_array($finalstring, $stackarray)){
				//wenn das vorherige file nicht das zu ladende ist (F5 exception)
				if($finalstringbefore != $finalstring){
					//position vom zu ladenden file im vorherigen stack herausfinden
					$number = array_search($finalstring, $stackarray);

					//erstellen von iterator variable $i und array variable für die iterierten teile drin zu speichern
					$i = 0;
					$finalstackarray = array();
					//durch den vorherigen stack durchiterieren
					foreach($stackarray as $value){
						//wenn die anzahl iterationen kleiner als die position
						//vom zu ladenden file ist
						if($i <= $number){
							//den teil aus dem stack in das array schreiben und iterator variable um 1 erhöhen
							$finalstackarray[$i] = $value;
							$i++;
						}
					}
					//das array mit / zeichen zwischen den elementen zusammensetzen 
					$finalstring = implode("/", $finalstackarray);
					//am schluss ein / zeichen anfügen
					$finalstring = ''.$finalstring.'/';
					//den neuen stack setzen
					$_SESSION['stack'] = $finalstring;
				}
			}
			//ansonsten das neue file mit einem / appenden
			else{
				$_SESSION['stack'] .= $finalstring.'/';
			}
		}
		//ansonsten das neue file mit einem / appenden
		else{
			$_SESSION['stack'] .= $finalstring.'/';
		}
	}

	//Methode um alle Aktivitätarten als Select-Option im Edit-Modus als ein String zusammenzufassen
	//$id ist die zuvor ausgewählte Aktivitätart
	function getArt($id){
		$allarts = getAllArts();
		$result = '';
		while($row = mysqli_fetch_assoc($allarts)){
			$result .= getOptionSelect($row, $id);
		}
		return $result;
	}

	//Wiederum Methode um alle Aktivitätarten als Select-Option im Edit-Modus als ein String zusammenfassen
	//, jedoch nur Aktivitätsarten zum einschreiben
	//$id ist die zuvor Ausgewählte Aktivitätsart
	function getArtEinschreiben($id){
		$allarts = getAllArts();
		$result = '';
		while($row = mysqli_fetch_assoc($allarts)){
			if($row['einschreiben'] == "1"){
				$result .= getOptionSelect($row, $id);
			}
		}
		return $result;
	}

	//Methode die für eine bestimmte Aktivitätsart eine Select-Option als String zusammenbaut
	//$row Aktivitätsart
	//$id die zuvor Ausgewählte Aktivitätsart
	function getOptionSelect($row, $id){
		if($row['id_art'] == $id){
			return '<option value="'.$row['name'].'" selected>'.$row['name'].'</option>';
		}
		else{
			return '<option value="'.$row['name'].'">'.$row['name'].'</option>';
		}
	}

	//Methode um alle benötigten attribute von einer Aktivität zu validieren
	function validateActivity($artofactivity, $startdate, $starttime, $enddate, $endtime, $writeindate, $writeintime){
		//das format des datums und der zeit durch funktion validateDateTime ändern
		$startdatetime = validateDateTime($startdate, $starttime);
		$enddatetime = validateDateTime($enddate, $endtime);

		//die aktivitätsartid via des aktivitätsartnamens aus der datenbank holen
		$artid = getArtIDByName($artofactivity);
		//wenn es eine aktivität zum einschreiben ist
		if($writeintime != null & $writeindate != null){
			//das format des datums und der zeit von der einschreibzeit ändern
			$writeindatetime = validateDateTime($writeindate, $writeintime);
			//array mit allen benötigten daten zurückgeben
			return array("startzeit"=>$startdatetime, "endzeit"=>$enddatetime, "art_id"=>$artid, "einschreibezeit"=>$writeindatetime);
		}
		else{
			//array mit allen benötigten daten zurückgeben
			return array("startzeit"=>$startdatetime, "endzeit"=>$enddatetime, "art_id"=>$artid);
		}
	}

	//Methode um das format von datum und zeit zu ändern
	function validateDateTime($date, $time){
		//die string werte zu zeit werten machen
		$time = strtotime($time);
		$date = strtotime($date);

		//die stunden und minuten aus der zeit variable lesen
		$hours = date('G', $time);
		$minutes = date('i', $time);

		//den monat, den tag im monat und das yahr aus der datum variable lesen
		$month = date('n', $date);
		$day = date('j', $date);
		$year = date('Y', $date);

		//aus den herausgelesenen daten ein neues datum erstellen
		$newdate = mktime($hours,$minutes,0,$month,$day,$year);
		//dieses datum formatieren und zurückgeben
		return date("Y-m-d H:i:s", $newdate);
	}

	//Methode um das datum zurückzugeben
	function returnDate($olddate){
		return date("Y-m-d", strtotime($olddate));
	}

	//Methode um die Zeit zurückzugeben
	function returnTime($oldtime){
		return date("H:i", strtotime($oldtime));
	}

	//Methode um anzahl tage und minuten bis zu einem zeitpunkt herauszufinden
	function getDaysHours($time){
		//datum und zeit bei leerzeichen trennen und dann einzeln als datum und zeit speichern
		$trimmed1 = explode(' ',$time);
		$date1 = $trimmed1[0];
		$time1 = $trimmed1[1];

		//jetziges datum und zeit holen, trennen, und einzeln als datum und zeit speichern
		$time2 = date('Y-m-d H:i:s');
		$trimmed2 = explode(' ', $time2);
		$date2 = $trimmed2[0];
		$time2 = $trimmed2[1];

		//anzahltage und anzahl minuten zwischen den daten und den zeiten ausrechnen
		$days = (strtotime($date1) - strtotime($date2)) / (60*60*24);
		$minutes = round((strtotime($time1) - strtotime($time2)) / 60,0);

		//wenn mehr als 1 tag differenz
		if($days != 0){
			//wenn es keine minuten hat
			if($minutes < 0){
				//speichern in wievielen tagen
				$result = 'In weniger als ' . $days . ' Tag/en';
			}
			else{
				//speichern in wievielen tagen und minuten
				$result = 'In ' . $days . ' Tag/en und ' . $minutes . ' Minute/n';
			}
		}
		else{
			//anzahl minuten speichern
			$result = 'In ' . $minutes . ' Minute/n';
		}
		//den string zurückgeben
		return $result;
	}

	//Methode für die Zahlen 1 oder 0 Ja oder Nein auszugeben
	function getJaNein($id){
		if($id == 1){
			return 'Ja';
		}
		else{
			return 'Nein';
		}
	}

	//Methode um für den Einschreiben Wert den richtigfen radio Button auszuwählen
	function getEinschreiben($einschreiben){
		if($einschreiben == '1'){
			return '<input id="froms_radio_left" class="forms_radio" type="radio" name="einschreiben" value="true" checked>
				<label for="true">Ja</label>
				<input class="forms_radio" type="radio" name="einschreiben" value="false">
				<label for="false">Nein</label>';
		}
		else{
			return '<input id="froms_radio_left" class="forms_radio" type="radio" name="einschreiben" value="true">
				<label for="true">Ja</label>
				<input class="forms_radio" type="radio" name="einschreiben" value="false" checked>
				<label for="false">Nein</label>';
		}
	}

	function getEinzeiler($einzeiler){
		if($einzeiler == '1'){
			return '<input id="froms_radio_left" class="forms_radio" type="radio" name="einzeiler" value="true" checked>
				<label for="true">Ja</label>
				<input class="forms_radio" type="radio" name="einzeiler" value="false">
				<label for="false">Nein</label>';
		}
		else{
			return '<input id="froms_radio_left" class="forms_radio" type="radio" name="einzeiler" value="true">
				<label for="true">Ja</label>
				<input class="forms_radio" type="radio" name="einzeiler" value="false" checked>
				<label for="false">Nein</label>';
		}
	}

	//Methode um für den Obligationswert den richtigen RadioButton auszuwählen
	function getObligation($obligation){
		if($obligation == 1){
			return '<input id="froms_radio_left" class="forms_radio" type="radio" name="obligation" value="true" checked>
				<label for="true">Ja</label>
				<input class="forms_radio" type="radio" name="obligation" value="false">
				<label for="false">Nein</label>
			';
		}
		else{
			return '<input id="froms_radio_left" class="forms_radio" type="radio" name="obligation" value="true">
				<label for="true">Ja</label>
				<input class="forms_radio" type="radio" name="obligation" value="false" checked>
				<label for="false">Nein</label>
			';
		}

	}

	//alle Datenbankmethoden aus dem file database.php laden
	require_once 'database.php';
?>