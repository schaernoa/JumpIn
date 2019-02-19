<?php
    //Klasse Activity speichert alle Daten einer Aktivität im Wochenplan
    class Activity{
        private $id_aktivitaet;
        private $aktivitaetsname;
        private $startzeit;
        private $endzeit;
        private $activityclass;
        private $height;
        private $width;
        private $left;
        private $top;
        private $column;
        private $number = 0;

        public function __construct($id_aktivitaet, $aktivitaetsname, $startzeit, $endzeit, $activityclass, $column, $number) {
            $this->id_aktivitaet = $id_aktivitaet;
            $this->aktivitaetsname = $aktivitaetsname;
            $this->startzeit = $startzeit;
            $this->endzeit = $endzeit;
            $this->activityclass = $activityclass;
            $this->column = $column;
            $this->number = $number;
        }

        public function getAktivitaetid() {
            return $this->id_aktivitaet;
        }
        public function getAktivitaetsname() {
            return $this->aktivitaetsname;
        }
        public function getStartzeit() {
            return $this->startzeit;
        }
        public function getEndzeit() {
            return $this->endzeit;
        }
        public function getActivityClass() {
            return $this->activityclass;
        }
        public function getHeight() {
            return $this->height;
        }
        public function getWidth() {
            return $this->width;
        }
        public function getLeft() {
            return $this->left;
        }
        public function getTop() {
            return $this->top;
        }
        public function getColumn() {
            return $this->column;
        }
        public function getNumber() {
            return $this->number;
        }

        public function setHeight($height){
            $this->height = $height;
        }
        public function setWidth($width){
            $this->width = $width;
        }
        public function setLeft($left){
            $this->left = $left;
        }
        public function setTop($top){
            $this->top = $top;
        }
    }
    //Globale Variablen
    global $daylistcolumns, $daylisttime, $nowline, $colors, $activityclasses;
    $colors = array("286DA8", "CD5360", "B37D4E", "438496", "A895E2", "780CE8", "E8880C", "9B7E84", "67C06B", "362866", "664222", "0D375B", "802731", "A35971", "EC9B24", "009B32", "4A6068", "4E383D", "8E3306", "867A4A");
    $nowline = false;
    $daylistcolumns = array();
    $daylisttime = array();
    $activityclasses = array();
    buildWeekschedule();

    //Error Session leeren
    $_SESSION['error'] = NULL;

    //Methode buildWeekschedule steuert den ganzen Aufbau des Wochenplans
    function buildWeekschedule(){
        $userid = getUserIDByUsername($_SESSION['benutzer_app']);
        setDayList($userid);
        setValuesDayList();
        printWeekschedule();
    }

    //Methode setDayList um zwei Listen zu erstellen
    //Die eine in Tage unterteilt und nach Zeit geordnet($daylisttime) und die andere ist in Tage und Spalten unterteilt und nach Zeit geordnet($daylistcolumns)
    //$userid: ist der Benutzer des Wochenplans
    function setDayList($userid){
        global $daylistcolumns, $daylisttime, $activityclasses;
        $activities = getActivityByUserID($userid);
        $activitybefore;
        $number = 1;
        //Für alle Aktivitäten des Benutzers
        while($activity = mysqli_fetch_assoc($activities)){
            //Wenn die Aktivität valid ist
            if(isValidActivity($activity, $userid)){
                //Wenn es nicht die erste Aktivität ist
                if($activitybefore != NULL){
                    //Wenn es nicht derselbe Tag wie der der Aktivität zuvor ist
                    if(getDateString($activity['startzeit']) != getDateString($activitybefore['startzeit'])){
                        $daytime = array();
                        $daycolumns = array();
                        $column = array();
                        //neues Aktivität Objekt
                        $activityobject = new Activity($activity['id_aktivitaet'], $activity['aktivitaetsname'], $activity['startzeit'], $activity['endzeit'], $activity['art_id'], 0, $number);
                        //Objekt in beiden Listen integrieren
                        array_push($daytime, $activityobject);
                        array_push($daylisttime, $daytime);
                        array_push($column, $activityobject);
                        array_push($daycolumns, $column);
                        array_push($daylistcolumns, $daycolumns);
                    }
                    else{
                        $daycolumns = $daylistcolumns[count($daylistcolumns) - 1];
                        $columns = count($daycolumns);
                        //Finde heraus in welcher Spalte es Platz für die neue Aktivität hat
                        $nextcolumn = getNextColumn($activity, $daycolumns, $columns, 1);
                        //das neue Aktivität Objekt erstellen
                        $activityobject = new Activity($activity['id_aktivitaet'], $activity['aktivitaetsname'], $activity['startzeit'], $activity['endzeit'], $activity['art_id'], $nextcolumn, $number);
                        //das neue Objekt in beiden Listen an der richtigen Stelle integrieren
                        array_push($daylisttime[count($daylisttime) - 1], $activityobject);
                        if($nextcolumn >= $columns){
                            $column = array();
                            array_push($column, $activityobject);
                            array_push($daylistcolumns[count($daylistcolumns) - 1], $column);
                        }
                        else{
                            array_push($daylistcolumns[count($daylistcolumns) - 1][$nextcolumn], $activityobject);
                        }
                    }
                }
                else{
                    $daytime = array();
                    $daycolumns = array();
                    $column = array();
                    //neues Aktivität Objekt erstellen
                    $activityobject = new Activity($activity['id_aktivitaet'], $activity['aktivitaetsname'], $activity['startzeit'], $activity['endzeit'], $activity['art_id'], 0, $number);
                    //Objekt in beiden Listen integrieren
                    array_push($daytime, $activityobject);
                    array_push($daylisttime, $daytime);
                    array_push($column, $activityobject);
                    array_push($daycolumns, $column);
                    array_push($daylistcolumns, $daycolumns);
                }
                //Wenn die Aktivitätsart noch nicht im Aktivitätklassen Array ist, integriere sie
                //Wird gebraucht um den verschiedenen Aktivitätsarten im Wochenplan verschiedene Farben zu geben
                if(!in_array($activity['art_id'], $activityclasses)){
                    array_push($activityclasses, $activity['art_id']);
                }
                //die Aktivität von zuvor wird zu der aktuellen
                $activitybefore = $activity;
                $number++;
                $faktor = 0;
            }
        }
    }

    //Methode um zu prüfen ob eine Aktivität einem Benutzer zugehört
    //$activity: die Aktivität
    //$userid: der Benutzer
    function isValidActivity($activity, $userid){
        //Wenn es eine Aktivität zum einschreiben ist
        if($activity['aktivitaetblock_id'] != NULL){
            $writtenin = getWrittenIn($userid, $activity['id_aktivitaet']);
            //Wenn der Benutzer eingeschrieben ist
            if($writtenin['aktivitaet_id'] == $activity['id_aktivitaet']){
                return TRUE;
            }
            else{
                return FALSE;
            }
        }
        else{
            return TRUE;
        }
    }

    //Methode um herauszufinden in welche Spalte eine Aktivität kommt
    //$activity: die Aktivität
    //$day: das Array vom Tag mit allen Spalten die schon existieren drin
    //$columns: die Anzahl Spalten im $day Array
    //$columnsless: die Anzahl an Spalten in der Rückwärts vom Maximum geprüft wird ob es Platz hat
    function getNextColumn($activity, $day, $columns, $columnsless){
        //Hat es in der Spalte die mit $columnsless gewählt wird Platz für die neue Aktivität
        if(strtotime($activity['startzeit']) - strtotime($day[$columns - $columnsless][count($day[$columns - $columnsless]) - 1]->getEndzeit()) < 0){
            //Wenn es insgesamt mehr Spalten hat als mit $columnsless zurück geschaut wird
            if($columns > $columnsless){
                //wiederhole den ganzen Spass solange, bis etwas zurückgegeben wird und returne das
                return getNextColumn($activity, $day, $columns, $columnsless + 1);
            }
            else{
                //returne das Maximum der Spalten -> füge eine neue Spalte hinzu
                return $columns;
            }
        }
        else{
            $returncolumns = $columns;
            //WIederhole soviel wie es Spalten hat
            for ($i = 1; $i <= $columns; $i++){
                //Wenn es in einer Spalte Platz hat überschreibe $returncolumns auf die aktuelle Spalte
                if(strtotime($activity['startzeit']) - strtotime($day[$columns - $i][count($day[$columns - $i]) - 1]->getEndzeit()) >= 0){
                    $returncolumns = $columns - $i;
                }
            }
            //returne die herausbekommene Spalte
            return $returncolumns;
        }
    }

    //Methode um jeder Aktivität seine physikalischen Werte zu geben: Höhe, Breite, Abstand von Links und der Abstand von oben
    function setValuesDayList(){
        global $daylistcolumns, $daylisttime;
        //Für jeden Tag im $daylisttime Array
        foreach($daylisttime as $day){
            $gaptobefore = -10;
            $overlapping = 0;
            //Für jede Aktivität im Tag
            foreach($day as $activity){
                //Wenn die Aktivität mit irgendeiner anderen überschneidet
                if(!isOverlapping($day, $activity)){
                    //Abstand mehr nach oben um 10 erhöhen
                    $gaptobefore += 10;
                    $overlapping = 0;
                }
                else{
                    //Wenn es die erste Aktivität nach einer überschneidenden Sektion an Aktivitäten ist
                    if($overlapping == 0){
                        $gaptobefore += 10;
                    }
                    /*else{
                        //hol die Aktivität mit der grössten Endzeit vor der aktuellen Aktivität
                        $lastactivity = getLastEndzeit($day, $activity);
                        //Wenn eine solche Aktivität existiert
                        if($lastactivity != NULL){
                            //Wenn die Endzeit der vorderen Aktivität kleiner oder gleich als die Startzeit der jetzigen Aktivität ist
                            if(strtotime($lastactivity->getEndzeit()) <= strtotime($activity->getStartzeit())){
                                //Wenn beide Aktivitäten in der ersten Spalte sind
                                if($activity->getColumn() == 0 && $lastactivity->getColumn() == 0){
                                    $gaptobefore += 10;
                                }
                            }
                        }
                    }*/
                    $overlapping++;
                }
                //Setze alle physikalischen Werte für die Aktivitäten
                getHeight($activity);
                getWidth($daylistcolumns, $daylisttime, $day, $activity);
                getLeft($daylistcolumns, $daylisttime, $day, $activity);
                getTop($daylisttime, $day, $activity, $gaptobefore);
            }
        }
    }

    //Methode um zu schauen ob eine Aktivität in irgendeiner Weise mit einer anderen überlappt
    //$day: der Tag als Array mit allen Aktivitäten nach Zeit geordnet als Inhalt
    //$activity: die Aktivität die zu prüfen ist
    function isOverlapping($day, $activity){
        global $daylistcolumns, $daylisttime;
        //hole die anzahl Spalten die dieser Tag hat
        $allcolumns = count($daylistcolumns[array_search($day, $daylisttime)]);
        //hole die Nummer der Spalte auf der die Aktivität ist
        $column = $activity->getColumn();
        //Solange wie es Spalten gegen rechts hat
        for($i = 1; $i <= $allcolumns - ($column + 1); $i++){
            //für jede Aktivität in einer der Spalten gegen rechts
            foreach($daylistcolumns[array_search($day, $daylisttime)][$column + $i] as $activitytwo){
                //Wenn diese Aktivität irgendwie mit der vom Parameter überschneidet
                if(!(strtotime($activity->getEndzeit()) <= strtotime($activitytwo->getStartzeit()) || strtotime($activitytwo->getEndzeit()) <= strtotime($activity->getStartzeit()))){
                    return true;
                }
            }
        }
        //Solange wie es Spalten hat
        for($i = 1; $i < $column + 1; $i++){
            //für jede Aktivität in einer der Spalten gegen links
            foreach($daylistcolumns[array_search($day, $daylisttime)][$column - $i] as $activitytwo){
                //Wenn diese Aktivität irgendwie mit der vom Parameter überschneidet
                if(!(strtotime($activity->getEndzeit()) <= strtotime($activitytwo->getStartzeit()) || strtotime($activitytwo->getEndzeit()) <= strtotime($activity->getStartzeit()))){
                    return true;
                }
            }
        }
        return false;
    }

    //Methode um die Aktivität mit der grössten Endzeit herauszufinden, wo die Endzeit jedoch aber kleiner ist als $activity's Startzeit
    //$day: ein Tag Array mit Aktivitäten gefüllt, entsprungen von $daylisttime
    //$activity: Aktivität Objekt
    function getLastEndzeit($day, $activity){
        global $daylisttime;
        $biggestendnumber = 0;
        $biggestend;
        //für jede Aktivität vom selben Tag wie $day
        foreach($daylisttime[array_search($day, $daylisttime)] as $activitytwo){
            //Wenn die Endzeit von dieser Aktivität kleiner ist als die Startzeit der Aktivität vom Parameter $activity
            if(strtotime($activitytwo->getEndzeit()) < strtotime($activity->getStartzeit())){
                $end = strtotime($activitytwo->getEndzeit());
                //Wenn die Endzeit dieser Aktivität grösser ist als jede bisher durchiterierte
                if($end > $biggestendnumber){
                    $biggestendnumber = $end;
                    $biggestend = $activitytwo;
                }
            }
        }
        return $biggestend;
    }

    //Methode um die Höhe einer Aktivität zu setzen
    //$activity: die Aktivität von der sie Höhe bestimmt wird
    function getHeight($activity){
        $activity->setHeight("height: ".calculateHeight($activity->getStartzeit(), $activity->getEndzeit())."px;");
    }

    //Methode für die Höhe anhand von zwei Zeiten zu berechnen
    //$starttime: ist die Startzeit
    //$endtime: ist die Endzeit
    function calculateHeight($starttime, $endtime){
        $minutes = round((strtotime($endtime) - strtotime($starttime)) / 60,0);
        return $minutes;
    }

    //Methode für die Breite einer Aktivität zu bestimmen
    //$daylistcolumns: das ultimative Array mit Spalten
    //$daylisttime: das Ultimative Array ohne Spalten
    //$day: ein Tag Array mit Aktivitäten gefüllt
    //$activity: das Aktivität Objekt von dem die breite zu bestimmen ist
    function getWidth($daylistcolumns, $daylisttime, $day, $activity){
        $allcolumns = count($daylistcolumns[array_search($day, $daylisttime)]);
        $column = $activity->getColumn();
        $widthnumber = 1;
        //Für jede Spalte die es rechts von der aktuellen Spalte noch hat
        for($i = 1; $i <= $allcolumns - ($column + 1); $i++){
            //Für jede Aktivität in der aktuellen Spalte rechts von der Urprungsspalte
            foreach($daylistcolumns[array_search($day, $daylisttime)][$column + $i] as $activitytwo){
                //Wenn es mit einer Aktivität von dieser Spalte überschneidet, herausbreaken
                if(!(strtotime($activity->getEndzeit()) <= strtotime($activitytwo->getStartzeit()) || strtotime($activitytwo->getEndzeit()) <= strtotime($activity->getStartzeit()))){
                    break 2;
                }
            }
            //Die Aktivität nach rechts verlängern
            $widthnumber++;
        }
        $width = "width: calc(((100%) * (".$widthnumber." / ".$allcolumns.")) - 25px);";
        $activity->setWidth($width);
    }

    //Methode für den Abstand zum linken Rand von einer Aktivität zu berechnen
    //$daylistcolumns: das ultimative Array mit Spalten
    //$daylisttime: das Ultimative Array ohne Spalten
    //$day: ein Tag Array mit Aktivitäten gefüllt
    //$activity: das Aktivität Objekt von dem der Abstand nach Links zu bestimmen ist
    function getLeft($daylistcolumns, $daylisttime, $day, $activity){
        $allcolumns = count($daylistcolumns[array_search($day, $daylisttime)]);
        $column = $activity->getColumn();
        $left = "left: calc((100% * (".$column." / ".$allcolumns.")) + 10px);";
        $activity->setLeft($left);
    }

    //Methode für den Abstand von einer Aktivität nach oben zu bestimmen
    //$daylisttime: das Ultimative Array ohne Spalten
    //$day: ein Tag Array mit Aktivitäten gefüllt
    //$activity: das Aktivität Objekt von dem der Abstand nach Oben zu bestimmen ist
    //$gaptobefore: die Anzahl Pixel die noch dazukommen für Lücken zu gestalten
    function getTop($daylisttime, $day, $activity, $gaptobefore){
        //berechne die Absolute Höhe von Startzeit der Aktivität zur Startzeit der allerersten Aktivität
        $diffrenceabsolute = calculateHeight($daylisttime[array_search($day, $daylisttime)][0]->getStartzeit(), $activity->getStartzeit());
        //Berechne die Pixel der Zeitlücken die in der Absoluten Zeit vorkommen
        $gapslength = getGapsLength($day, $activity);
        $topnumber =  ($diffrenceabsolute + $gaptobefore) - $gapslength;
        $top = "top: ".$topnumber."px;";
        $activity->setTop($top);
        return $gaptobefore;
    }

    //Methode um die Lückenlänge in einem Tag bis zu einer bestimmten Aktivität zu berechnen
    //$day: ein Tag Array gefüllt mit Aktivitäten
    //$activity: ein Aktivität Objekt
    function getGapsLength($day, $activity){
        global $daylistcolumns, $daylisttime;
        $gap = 0;
        //Für jede Aktivität in der ersten Spalte des Tages 
        foreach($daylistcolumns[array_search($day, $daylisttime)][0] as $activitytwo){
            //Wenn die Nummerierung kleiner ist als die im Parameter
            if($activity->getNumber() >= $activitytwo->getNumber()){
                //Die Lücke zum vorderen Ende bestimmen
                $gapshort = calculateHeight(getBiggestEnd($day, $activitytwo), $activitytwo->getStartzeit());
                if($gapshort > 0){
                    $gap += $gapshort;
                }
            }
        }
        return $gap;
    }

    //Methode um die Grösste Endzeit herauszufinden, wo die Startzeit kleiner ist als die des $activity Parameters
    //$day: ein Tag Array gefüllt mit Aktivitäten
    //$activity: ein Aktivität Objekt
    function getBiggestEnd($day, $activity){
        global $daylisttime;
        $biggestendnumber = 0;
        $biggestend;
        //Für jede Aktivität im Tag des $day Parameters
        foreach($daylisttime[array_search($day, $daylisttime)] as $activitytwo){
            //Wenn die Startzeit dieser Aktivität kleiner ist als die des $activity Parameters
            if(strtotime($activitytwo->getStartzeit()) < strtotime($activity->getStartzeit())){
                $end = strtotime($activitytwo->getEndzeit());
                //Wenn die Endzeit grösser ist als jede zuvor geprüfte
                if($end > $biggestendnumber){
                    $biggestendnumber = $end;
                    $biggestend = $activitytwo->getEndzeit();
                }
            }
        }
        //Wenn es kein solche Endzeit gab
        if($biggestend == NULL){
            $biggestend = $activity->getStartzeit();
        }
        return $biggestend;
    }

    //Methode um alle gespeicherten Daten nun endlich auszugeben
    function printWeekschedule(){
        global $daylisttime;
        global $nowline;
        //für jeden Tag im ultimativen array ohne Spalten
        foreach($daylisttime as $day){
            $blocker = true;
            //die Informationen des tages ausgeben
            echoDay($day[0]->getStartzeit(), colorDay($day[0], date('Y-m-d H:i:s')));
            //Für jede Aktivität im Tag
            foreach($day as $activity){
                //Die Aktivität ausgeben
                echoActivity($activity->getStartzeit(), $activity->getEndzeit(), $activity->getAktivitaetid(), $activity->getAktivitaetsname(), $activity->getHeight(), $activity->getWidth(), $activity->getLeft(), $activity->getTop(), $activity->getActivityClass());
                //Wenn die Endzeit der Aktivität die grösste Endzeit hat
                if($activity->getEndzeit() == getBiggestEndHeight($day)){
                    if($blocker){
                        //einen Platz Blocker ausgeben um die Tage divs auszudehnen
                        echoDivBlocker($activity->getHeight(), $activity->getTop());
                        $blocker = false;
                    }
                }
            }
            //Wenn es den Jatzt Zeiger noch nicht ausgegeben hat
            if(!$nowline){
                //gebe den Now Zeiger aus
                getNowLine($daylisttime, $day);
            }
            //schliesse die Divs des tages
            echoCloseDay();
        }
    }

    //Methode um den Tag auszugeben
    //$starttime: die Startzeit einer Aktivität
    //$cssday: die Style Massnahmen des Tages
    function echoDay($starttime, $cssday){
        echo '
            <div class="div_wochenplan_day">
                <div class="div_wochenplan_day_left" style="'.$cssday.'">
                    <p class="p_wochenplan_day_title">
                        '.getDay($starttime).'
                    </p>
                    <p class="p_wochenplan_day_undertitle">
                        '.getDateString($starttime).'
                    </p>
                </div>
                <div class="div_wochenplan_day_right">
        ';
    }

    //Methode um die Schrift des tages zu färben, je nach dem ob es der aktuelle tag ist oder nicht
    //$activity: eine Aktivität des tages
    //$datenow: das aktuelle Datum und Zeit
    function colorDay($activity, $datenow){
        //Wenn der Tag nicht derselbe ist wie jetzt
        if(strtotime(date("Y-m-d", strtotime($datenow))) != strtotime(date("Y-m-d", strtotime($activity->getStartzeit())))){
            return 'color: grey;';
        }
        else{
            return 'color: #584125;';
        }
    }

    //Methode für die Grösste Endzeit eines Tages zu bekommen
    //$day: ein Tag Array gefüllt mir Aktivitäten
    function getBiggestEndHeight($day){
        global $daylisttime;
        $biggestendnumber = 0;
        $biggestend;
        //Für jede Aktivität in diesem Tag
        foreach($daylisttime[array_search($day, $daylisttime)] as $activitytwo){
            $end = strtotime($activitytwo->getEndzeit());
            //Wenn die Endzeit grösser ist als jede zuvor geprüfte
            if($end > $biggestendnumber){
                $biggestendnumber = $end;
                $biggestend = $activitytwo->getEndzeit();
            }
        }
        return $biggestend;
    }

    //Methode um den Platz Blocker zu berechnen und auszugeben
    //$height: die Höhe der letzten Aktivität eines tages
    //$top: der Abstand nach oben der letzten Aktivität eines tages
    function echoDivBlocker($height, $top){
        //der css code auseinandernehmen um es zu einem margin-top zu machen
        $parts = explode(" ",$top);
        $pixel = explode("p", $parts[1]);
        $newtop = intval($pixel[0]) + 20;
        echo '
            <div style="'.$height.' margin-top:'.$newtop.'px; visibility: hidden;"></div>
        ';
    }

    //Methode um eine Aktivität auszugeben
    //Alle Parameter sind Eigenschaftebn eines Aktivität Objektes die benötigt werden um Sie auszugeben
    function echoActivity($starttime, $endtime, $activityid, $activityname, $containerheight, $containerwidth, $left, $top, $backgoundcolor){
        global $colors, $activityclasses;
        echo '
            <form action="wochenplan_view" method="post">
                <button class="button_wochenplan" style="'.$containerheight.' '.$containerwidth.' '.$left.' '.$top.' background-color: #'.$colors[array_search($backgoundcolor, $activityclasses)].';">
                    <div class="div_wochenplan_aktivitaet">
        ';
        //Wenn die Aktivität eine Viertelstunde oder kürzer dauert
        if(strtotime($endtime) - strtotime($starttime) <= 900){
            echo '
                <p class="p_wochenplan_aktivitaet_title" style="font-size: 9pt;">
                    '.$activityname.'
                </p>
            ';
        }
        else{
            echo '
                <p class="p_wochenplan_aktivitaet_title">
                    '.$activityname.'
                </p>
            ';
        }
        //Wenn die Aktivität kürzer als eine Halbestunde dauert
        if(strtotime($endtime) - strtotime($starttime) > 1800){
            echo '
                <p class="p_wochenplan_aktivitaet_time">
                    '.getHours($starttime).'- '.getHours($endtime).'
                </p>
            ';
        }
        echo '
                    </div>
                </button>
                <input type="hidden" name="id" value="'.$activityid.'">
            </form>
        ';
    }

    //Methode um die Jetzt-Linie auszugeben, welche im Wochenplan anzeigt wo man sich gerade befindet
    //$daylisttime: die ultimative Liste ohne Spalten
    //$day: ein Tag in der $daylisttime Liste, gefüllt mit Aktivitäten
    function getNowLine($daylisttime, $day){
        global $nowline;
        $now = date('Y-m-d H:i:s');
        //Wenn der jetzige Zeitpunkt vor der Startzeit der ersten Aktivität von diesem Tag ist
        if(strtotime($now) < strtotime($daylisttime[array_search($day, $daylisttime)][0]->getStartzeit())){
            echoNowLine(5);
            $nowline = true;
        }
        //Wenn der jetzige Zeitpunkt innerhalb von diesem Tag ist
        else if(strtotime($now) > strtotime($daylisttime[array_search($day, $daylisttime)][0]->getStartzeit()) && strtotime($now) < strtotime(getBiggestEndHeight($day))){
            $nowactivity = getActivityByNow($day, $now);
            //Wenn ein richtiges Resultat zurückkommt
            if($nowactivity[0] == 1){
                $parts = explode(" ",$nowactivity[1]->getTop());
                $pixel = explode("p", $parts[1]);
                $newtop = intval($pixel[0] + 5);
                echoNowLine($newtop);
            }
            else{
                //Calculate the height of now to the start of the day
                $diffrenceabsolute = calculateHeight($daylisttime[array_search($day, $daylisttime)][0]->getStartzeit(), $now);
                //get all time gaps between
                $gap = getGapNowPointer($now, $day);
                echoNowLine($diffrenceabsolute + getGapToBefore($now, $day) + 10 - $gap);
            }
            $nowline = true;
        }
        else{
            $lastElement = end($daylisttime);
            //Wenn es der letzte Tag im Array ist
            if($day == $lastElement){
                //der Abstand nach oben und die Höhe von der letzten Aktivität dieses Tages holen
                $top = end($day)->getTop();
                $height = end($day)->getHeight();
                //Die beiden Informationen zu den Zahlen wnadeln
                $parts = explode(" ",$top);
                $pixel = explode("p", $parts[1]);
                $newtop = intval($pixel[0]);
                $parts = explode(" ",$height);
                $pixel = explode("p", $parts[1]);
                $newheight = intval($pixel[0]);
                //Die Linie ausgeben 
                echoNowLine($newtop + $newheight + 12);
                $nowline = true;
            }
        }
    }

    //Methode um die Jetzt Linie auszugeben
    //$margintopnowpointer: der Abstand nach oben der die Linie hat
    function echoNowLine($margintopnowpointer){
        echo '
            <div class="nowline" style="top: '.$margintopnowpointer.'px;"></div>
            <div class="nowpoint" style="top: '.$margintopnowpointer.'px;"></div>
        ';
    }

    //Methode, dass der jetzt Zeiger in Lücken zwischen Aktivitäten stehen bleibt, wenn solange der momentane Zeitpunkt nicht in einer Aktivität vorkommt
    //$day: das tag Array gefüllt mit Aktivitäten
    //$now: der jetzige Zeitpunkt
    function getActivityByNow($day, $now){
        global $daylisttime;
        $lastactivity;
        $reallastactivity;
        //Für jede Aktivität im Tag
        foreach($day as $activity){
            if($lastactivity != NULL){
                if($reallastactivity == NULL){
                    $reallastactivity = $lastactivity;
                }
                //Wenn die Endzeit der letzten Aktivität grösser ist als die Endzeit von allen durchgegenagenen Aktivitäten
                if(strtotime($lastactivity->getEndzeit()) > strtotime($reallastactivity->getEndzeit())){
                    $reallastactivity = $lastactivity;
                }
                if($reallastactivity != NULL){
                    //Wenn sich der jetzige Zeitpunkt in einer Lücke befindet
                    if(strtotime($now) > strtotime($reallastactivity->getEndzeit()) && strtotime($activity->getStartzeit()) > strtotime($now)){
                        return array(1, $activity);
                    }
                }
            }
            $lastactivity = $activity;
        }
        return array(0);
    }

    //Methode um Zeitlücken zwischen Aktivitäten dem Jetzt Zeiger hinzuzufügen
    //$nowtime: der jetzige Zeitpunkt
    //$day: das Tag Array gefüllt mit Aktivitäten
    function getGapNowPointer($nowtime, $day){
        global $daylistcolumns, $daylisttime;
        $gap = 0;
        //Für jede Aktivität in der ersten Spalte des Tages des $day Parameters
        foreach($daylistcolumns[array_search($day, $daylisttime)][0] as $activitytwo){
            //Wenn der jetzige Zeitpunkt grösser ist als die Startzeit der Aktivität
            if(strtotime($nowtime) >= strtotime($activitytwo->getStartzeit())){
                //Die Lücke berechnen
                $gapshort = calculateHeight(getBiggestEnd($day, $activitytwo), $activitytwo->getStartzeit());
                //Wenn die Lücke grösser als 0 ist
                if($gapshort > 0){
                    $gap += $gapshort;
                }
            }
        }
        return $gap;
    }

    //Methode um die Anzahl physikalisch sehbaren Lücken bis zum momentanen Zeitpunkt zu bestimmen
    //$now: der momentane Zeitpunkt
    //$day: das Tag Array gefüllt mit Aktivitäten
    function getGaptoBefore($now, $day){
        global $daylisttime;
        $activitybefore;
        $gaptobefore = 0;
        $overlapping = 0;
        //Für jede Aktivität im Tag des $day Parameters
        foreach($daylisttime[array_search($day, $daylisttime)] as $activity){
            if($activitybefore != NULL){
                //Wenn der momentane Zeitpunkt zwischen zwei Aktivitäten ist
                if(strtotime($activitybefore->getEndzeit()) < strtotime($now) && strtotime($activity->getStartzeit()) > strtotime($now)){
                    return $gaptobefore; 
                }
            }
            //Wenn die Aktivität in irgendwelcher Weise überlappen
            if(!isOverlapping($day, $activity)){
                $gaptobefore += 10;
                $overlapping = 0;
            }
            else{
                if($overlapping == 0){
                    $gaptobefore += 10;
                }
                else{
                    $lastactivity = getLastEndzeit($day, $activity);
                    if($lastactivity != NULL){
                        //Wenn die letzte Endzeit kleiner oder gleich ist als aktuelle Startzeit
                        if(strtotime($lastactivity->getEndzeit()) <= strtotime($activity->getStartzeit())){
                            //Wenn die beiden Aktivitäten in der Spalte 0 sind
                            if($activity->getColumn() == 0 && $lastactivity->getColumn() == 0){
                                $gaptobefore += 10;
                            }
                        }
                    }
                }
                $overlapping++;
            }
            $activitybefore = $activity;
        }
    }

    //Methode für einen Tag zu schliessen
    function echoCloseDay(){
        echo '
                </div>
            </div>  
        ';
    }
?>