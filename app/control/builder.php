<?php
	//Methode um ein bestimmtes File zu Laden
	//$path: der Pfad des zu ladenden Files
    function build($path){
?>
        <!DOCTYPE html>
		<html>
			<head>
				<title>Jump-in App</title>
				<link rel="stylesheet" href="./css/style.css">
				<meta charset="UTF-8">
				<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
			</head>
			<body>
				<?php
					//holt den Header
					require_once './view/header.php'; 
				?> 
				<main>
					<?php
						//wenn der zu ladende Pfad nicht erlaubt ist wird der Pfad zur Home-Seite geändert
						if($_SESSION['benutzer_app']){
							if(inSessionInvalid($path)){
								$path = "./view/home.php";
							}
						}
						else{
							if(!inSessionValid($path)){
								$path = "./view/home.php";
							}
						}
						//das File vom Pfad holen
						require_once $path; 
					?> 
				</main>
			</body>
		</html>
		<?php	 
    }
	
	//alle Datenbank Methoden holen
	require_once '../konfiguration/control/database.php'; 
	
	//Methode um nicht erlaubte Files hinzuzufügen
	//$file: der Pfad des hinzufügenden Files
	function addSessionInvalid($file){
		$invalidfiles = $_SESSION['invalidfiles'];
		$schnittmenge = array_diff($file, $invalidfiles);
		foreach($schnittmenge as $value){
			array_push($invalidfiles, $value);
		}
		$_SESSION['invalidfiles'] = $invalidfiles;
	}

	//Methode um nicht erlaubte Files zu erlauben
	//$files: Array der neu erlaubten Files
	function removeSessionInvalid($files){
		$invalidfiles = $_SESSION['invalidfiles'];
		$difference = array_diff($invalidfiles, $files);
		$_SESSION['invalidfiles'] = $difference;
	}

	//Methode um zu schauen ob File erlaubt ist wenn Logged-in
	//$file: zu kontrollierendes File
	function inSessionInvalid($file){
		$invalidfiles = $_SESSION['invalidfiles'];
		if(in_array(splitString($file), $invalidfiles)){
			return true;
		}
		else{
			return false;
		}
		
	}

	//Methode um zu schauen ob File erlaubt ist wenn Logged-out
	//$file: zu kontrollierendes File
	function inSessionValid($file){
		$validfiles = $_SESSION['validfiles'];
		if(in_array(splitString($file), $validfiles)){
			return true;
		}
		else{
			return false;
		}
	}

	//Methode um vom Pfad des Files den Filenamen zu bekommen
	//$string: der Pfad vom File
	function splitString($string){
		$stringarray = explode("/", $string);
		$stringarray2 = explode(".", $stringarray[(count($stringarray) - 1)]);
		return $stringarray2[0];
	}

	//Methode um von einem Datum den Wochentag im 3-Buchstaben Format zu bekommen
	//$date: das Datum
	function getDay($date){
        $numericday = date("w", strtotime($date));

        if($numericday == 1){
            return 'Mon';
        }
        else if($numericday == 2){
            return 'Die';
        }
        else if($numericday == 3){
            return 'Mit';
        }
        else if($numericday == 4){
            return 'Don';
        }
        else if($numericday == 5){
            return 'Fre';
        }
        else if($numericday == 6){
            return 'Sam';
        }
        else{
            return 'Son';
        }
    }

	//Methode um von einem bestimmten Datum den Tag als Zahl und den Monat als Buchstaben zu bekommen
	//$date: das bestimmte Datum
    function getDateString($date){
        $day = date("j", strtotime($date));
        $numericmonth = date("n", strtotime($date));
        $month = "";

        if($numericmonth == 1){
            $month = 'Jan';
        }
        else if($numericmonth == 2){
            $month = 'Feb';
        }
        else if($numericmonth == 3){
            $month = 'Mär';
        }
        else if($numericmonth == 4){
            $month = 'Apr';
        }
        else if($numericmonth == 5){
            $month = 'Mai';
        }
        else if($numericmonth == 6){
            $month = 'Jun';
        }
        else if($numericmonth == 7){
            $month = 'Jul';
        }
        else if($numericmonth == 8){
            $month = 'Aug';
        }
        else if($numericmonth == 9){
            $month = 'Sep';
        }
        else if($numericmonth == 10){
            $month = 'Okt';
        }
        else if($numericmonth == 11){
            $month = 'Nov';
        }
        else{
            $month = 'Dez';
        }

        return ''.$day.'. '.$month.'';
    }

	//Methode um die Uhrzeit von einem bestimmten Zeitpunkt zu bekommen
	//$time: der bestimmte Zeitpunkt
    function getHours($time){
        return date("H:i", strtotime($time));
	}
	
	//Methode um von allen Aktivitätsarten eine Kachel in der Home Seite oder 
	//in der Navigation darzustellen wenn es für den Benutzer aktuell etwas einzuschreiben gibt
	//$source: legt fest von wo die Anfrage bekommt um das richtige Code Segment zurückzugeben 
	function getWriteinPossebilities($source){
		$arts = getAllArts();
		$counter = 0;
		$return = '';
		$userid = getUserIDByUsername($_SESSION['benutzer_app']);
        while($row1 = mysqli_fetch_assoc($arts)){
			//Wenn es eine Aktivitätsart zum einschreiben ist
            if($row1['einschreiben'] == "1"){
                $activityentities = getActivityentitiesByArtID($row1['id_art']);
                while($row2 = mysqli_fetch_assoc($activityentities)){
					//Wenn der jetzige Zeitpunkt nach Einschreibezeit des Aktivitätsblockes ist 
                    if(strtotime(date("Y-m-d H:i:s")) - strtotime($row2['einschreibezeit']) >= 0){
						if(getValidActivityentities($row2['id_aktivitaetblock'], $userid)){
							$activities = getActivityByActivityentityIDAndUserID($row2['id_aktivitaetblock'], $userid);
							while($row3 = mysqli_fetch_assoc($activities)){
								$writtenin = getWrittenIn($userid, $row3['id_aktivitaet']);
								//Wenn die Startzeit der Aktivität noch nicht der Vergangenheit angehört und man sich noch nicht eingeschrieben hat
								if(strtotime($row3['startzeit']) - strtotime(date("Y-m-d H:i:s")) >= 0 & empty($writtenin['aktivitaet_id'])){
									if($source == 'home'){
										echo '
											<form class="form_home" action="einschreiben_choice" method="post">
												<button class="button_home section'.$row1['name'].'">
													<p class="p_section">'.$row1['name'].'</p>
												</button>
												<input type="hidden" name="id_aktivitaetsart" value="'.$row1['id_art'].'">
											</form>
										';
									}
									else if($source == 'header'){
										$return .= '
											<form action="einschreiben_choice" method="post">
												<button class="button_navigation">
													<a class="a_header_special" href="">
														'.$row1['name'].'
													</a>
												</button>
												<input type="hidden" name="id_aktivitaetsart" value="'.$row1['id_art'].'">
											</form>
										';
									}
									$counter++;
									break 2;
								}
							}
						}
					}
                }
            }
		}
		if($counter == 0){
			$array = array();
            array_push($array, "einschreiben_choice", "validate_einschreiben_choice", "einschreiben_choice_aktivitaeten", "validate_einschreiben_choice_aktivitaeten", "einschreiben", "validate_einschreiben");
            addSessionInvalid($array);
		}
		else if($counter > 0){
			$array = array();
			array_push($array, "einschreiben_choice", "validate_einschreiben_choice");
			removeSessionInvalid($array);
		}
		if(!empty($return)){
			return $return;
		}
	}

	//Methode um herauszufinden ob eine Aktivität einen bestimmten Benutzer betrifft
	//$activityentityid: die Aktivität
	//$userid: der Benutzer
	function getValidActivityentities($activityentityid, $userid){
		$counter = 0;
		$activities = getActivityAndWrittenInByActivityentityIDAndUserID($activityentityid, $userid);
		while($row = mysqli_fetch_assoc($activities)){
			if(strtotime($row['startzeit']) - strtotime(date("Y-m-d H:i:s")) >= 0){
				if($row['aktivitaet_id'] != NULL){
					$counter++;
				}
			}
		}
		if($counter > 0){
			return FALSE;
		}
		else{
			return TRUE;
		}
	}

	//Methode um die Kachel Feedback anzuzeigen wenn der Zeitpunkt dazu gekommen ist
	//$source: legt fest von wo die Anfrage bekommt um das richtige Code Segment zurückzugeben
	function getFeedback($source){
		$feedbackcategory = getLowestFeedbackCategory();
		$feedbackcategories = getAllFeedbackCategories();
		$counter = 0;
		if(!empty($feedbackcategory) & !empty($feedbackcategories)){
			$counterdata = 0;
			$counteruser = 0;
			//zählt wie viele Feedbackkategorien es gibt und wie viele der benutzer ausgefüllt hat
			while($row = mysqli_fetch_assoc($feedbackcategories)){
				$counterdata++;
				$data = getUserFeedbackArrayByFeedbackCategoryID($row['id_feedbackkategorie'], getUserIDByUsername($_SESSION['benutzer_app']));
				if(!empty($data)){
					if($data['feedbackkategorie_id'] == $row['id_feedbackkategorie']){
						$counteruser++;
					}
					else{
						break;
					}
				}
				else{
					break;
				}
			}
			//Wenn die minimale Auschaltszeit erreicht worden ist
			if(strtotime($feedbackcategory['MIN(aufschaltszeit)']) - strtotime(date("Y-m-d H:i:s")) <= 0){
				//Wenn der benutzer nicht alle Feedbackkategorien ausgefüllt hat
				if($counterdata != $counteruser){
					if($source == 'home'){
						echo '
							<a class="a_section" href="feedback">
								<section class="section sectionFeedback">
									<p class="p_section_default">Feedback</p>
								</section>
							</a>
						';
					}
					else if($source == 'header'){
						$return = '
							<a href="feedback">Feedback</a>
						';
					}
					$counter++;
				}
			}
		}
		if($counter == 0){
			$array = array();
			array_push($array, "feedback", "feedback_categories", "validate_feedback_categories");
			addSessionInvalid($array);
		}
		else if($counter > 0){
			$array = array();
			array_push($array, "feedback");
			removeSessionInvalid($array);
		}
		if(!empty($return)){
			return $return;
		}
	}
?>