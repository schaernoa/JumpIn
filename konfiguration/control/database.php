<?php
    //Funktion um die Datenbankverbindung aufzubauen
    function getDatabase(){
        $db = array("localhost", "jumpin", "1234", "JumpIn");
        return new Mysqli($db[0], $db[1], $db[2], $db[3]);
    }
    
    function getAllUser(){
        $db = getDatabase();
        $sql = ("SELECT * FROM BENUTZER");
        $result = $db->query($sql);
        $db->close();
        return $result; 
    }

    function getAllUserOrdered(){
        $db = getDatabase();
        $sql = ("SELECT * FROM BENUTZER ORDER BY vorname");
        $result = $db->query($sql);
        $db->close();
        return $result; 
    }

    function getUserIDByUsername($username){
        $db = getDatabase();
        $sql = ("SELECT id_benutzer FROM BENUTZER WHERE benutzername = '$username' LIMIT 1");
        $result = $db->query($sql);
        $resultarray = mysqli_fetch_assoc($result);
        $db->close();
        return $resultarray['id_benutzer'];
    }

    function getPasswordByUsername($username){
        $db = getDatabase();
        $sql = ("SELECT passwort FROM BENUTZER WHERE benutzername = '$username' LIMIT 1");
        $result = $db->query($sql);
        $resultarray = mysqli_fetch_assoc($result);
        var_dump($resultarray);
        $db->close();
        return $resultarray['passwort'];
    }

    function getUserByID($id){
        $db = getDatabase();
        $sql = ("SELECT * FROM BENUTZER WHERE id_benutzer = '$id'");
        $result = $db->query($sql);
        $resultarray = mysqli_fetch_assoc($result);
        $db->close();
        return $resultarray;
    }

    function getUserByUsername($name){
        $db = getDatabase();
        $sql = ("SELECT * FROM BENUTZER WHERE benutzername = '$name'");
        $result = $db->query($sql);
        $resultarray = mysqli_fetch_assoc($result);
        $db->close();
        return $resultarray;
    }

    function getUserprenameByUsername($username){
        $db = getDatabase();
        $sql = ("SELECT vorname FROM BENUTZER WHERE benutzername = '$username'");
        $result = $db->query($sql);
        $resultarray = mysqli_fetch_assoc($result);
        $db->close();
        return $resultarray['vorname'];
    }

    function getUsernameByUsername($username){
        $db = getDatabase();
        $sql = ("SELECT benutzername FROM BENUTZER WHERE benutzername = '$username' LIMIT 1");
        $result = $db->query($sql);
        $resultarray = mysqli_fetch_assoc($result);
        $resultstring = $resultarray['benutzername'];
        $db->close();
        return $resultstring;
    }

    function getAllGroups(){
        $db = getDatabase();
        $sql = ("SELECT * FROM GRUPPE");
        $result = $db->query($sql);
        $db->close();
        return $result;
    }

    function getGroupByID($id){
        $db = getDatabase();
        $sql = ("SELECT * FROM GRUPPE WHERE id_gruppe = '$id'");
        $result = $db->query($sql);
        $resultarray = mysqli_fetch_assoc($result);
        $db->close();
        return $resultarray;
    }
    
    function getGroupnameByGroupname($groupname){
        $db = getDatabase();
        $sql = ("SELECT name FROM GRUPPE WHERE name = '$groupname' LIMIT 1");
        $result = $db->query($sql);
        $resultarray = mysqli_fetch_assoc($result);
        $resultstring = $resultarray['name'];
        $db->close();
        return $resultstring;
    }

    function getGroupnameByUsername($username){
        $db = getDatabase();
        $sql = ("SELECT g.name AS gruppenname FROM GRUPPE AS g INNER JOIN BENUTZER_GRUPPE AS bg ON g.id_gruppe=bg.gruppe_id INNER JOIN BENUTZER AS b ON bg.benutzer_id=b.id_benutzer WHERE b.benutzername = '" . $username . "'");
        $result = $db->query($sql);
        var_dump($result);
        $db->close();
        return $result;
    }

    function getGroupIDByName($name){
        $db = getDatabase();
        $sql = ("SELECT id_gruppe FROM GRUPPE WHERE name = '$name' LIMIT 1");
        $result = $db->query($sql);
        $resultarray = mysqli_fetch_assoc($result);
        $db->close();
        return $resultarray['id_gruppe'];
    }

    function getUserByGroupID($id){
        $db = getDatabase();
        $sql = ("SELECT b.id_benutzer AS id_benutzer, b.benutzername AS benutzername, b.name AS name, b.vorname AS vorname FROM BENUTZER AS b
            JOIN BENUTZER_GRUPPE AS bg ON bg.benutzer_id=b.id_benutzer
            WHERE bg.gruppe_id = '$id'");
        $result = $db->query($sql);
        $db->close();
        return $result;
    }

    function getGroupByUsernameAndLevel($name){
        $db = getDatabase();
        $sql = ("SELECT g.name AS name FROM GRUPPE AS g
            JOIN BENUTZER_GRUPPE AS bg ON bg.gruppe_id = g.id_gruppe
            JOIN BENUTZER AS b ON b.id_benutzer = bg.benutzer_id
            WHERE b.benutzername = '$name' ORDER BY g.level DESC LIMIT 1");
        $result = $db->query($sql);
        $resultarray = mysqli_fetch_assoc($result);
        $db->close();
        return $resultarray;
    }

    function getAllUserGroupsByUserID($userid){
        $db = getDatabase();
        $sql = ("SELECT * FROM BENUTZER_GRUPPE WHERE benutzer_id = '$userid'");
        $result = $db->query($sql);
        $db->close();
        return $result;
    }

    function getArtnameByArtname($artname){
        $db = getDatabase();
        $sql = ("SELECT name FROM ART WHERE name = '$artname' LIMIT 1");
        $result = $db->query($sql);
        $resultarray = mysqli_fetch_assoc($result);
        $resultstring = $resultarray['name'];
        $db->close();
        return $resultstring;
    }

    function getAllArts(){
        $db = getDatabase();
        $sql = ("SELECT * FROM ART");
        $result = $db->query($sql);
        $db->close();
        return $result;
    }

    function getArtByID($id){
        $db = getDatabase();
        $sql = ("SELECT * FROM ART WHERE id_art = '$id'");
        $result = $db->query($sql);
        $resultarray = mysqli_fetch_assoc($result);
        $db->close();
        return $resultarray;
    }

    function getArtIDByName($name){
        $db = getDatabase();
        $sql = ("SELECT * FROM ART WHERE name = '$name'");
        $result = $db->query($sql);
        $resultarray = mysqli_fetch_assoc($result);
        $db->close();
        return $resultarray['id_art'];
    }

    function getArtNameByID($id){
        $db = getDatabase();
        $sql = ("SELECT * FROM ART WHERE id_art = '$id'");
        $result = $db->query($sql);
        $resultarray = mysqli_fetch_assoc($result);
        $db->close();
        return $resultarray['name'];
    }

    function getArtByName($name){
        $db = getDatabase();
        $sql = ("SELECT * FROM ART WHERE name = '$name'");
        $result = $db->query($sql);
        $resultarray = mysqli_fetch_assoc($result);
        $db->close();
        return $resultarray;
    }

    function getAllActivitiesOrdered(){
        $db = getDatabase();
        $sql = ("SELECT * FROM AKTIVITAET ORDER BY startzeit");
        $result = $db->query($sql);
        $db->close();
        return $result;
    }

    function getActivityByID($id){
        $db = getDatabase();
        $sql = ("SELECT * FROM AKTIVITAET WHERE id_aktivitaet = '$id'");
        $result = $db->query($sql);
        $resultarray = mysqli_fetch_assoc($result);
        $db->close();
        return $resultarray;
    }

    function getActivityByActivityentityID($id){
        $db = getDatabase();
        $sql = ("SELECT * FROM AKTIVITAET WHERE aktivitaetblock_id = '$id'");
        $result = $db->query($sql);
        $db->close();
        return $result;
    }

    function getActivityByActivityentityIDAndUserID($aeid, $userid){
        $db = getDatabase();
        $sql = ("SELECT * FROM AKTIVITAET AS a
            JOIN AKTIVITAET_GRUPPE AS ag ON ag.aktivitaet_id = a.id_aktivitaet
            JOIN GRUPPE AS g ON g.id_gruppe = ag.gruppe_id
            JOIN BENUTZER_GRUPPE AS bg ON bg.gruppe_id = g.id_gruppe                
            WHERE bg.benutzer_id = '$userid' AND a.aktivitaetblock_id = '$aeid' ORDER BY a.startzeit");
        $result = $db->query($sql);
        $db->close();
        return $result;
    }
    
    function getActivityByUserID($id){
        $db = getDatabase();
        $sql = ("SELECT DISTINCT(a.id_aktivitaet) AS id_aktivitaet, a.aktivitaetsname, a.aktivitaetblock_id, a.art_id, a.treffpunkt, a.anzahlteilnehmer, a.startzeit, a.endzeit, a.info FROM AKTIVITAET AS a
            JOIN AKTIVITAET_GRUPPE AS ag ON ag.aktivitaet_id = a.id_aktivitaet
            JOIN GRUPPE AS g ON g.id_gruppe = ag.gruppe_id
            JOIN BENUTZER_GRUPPE AS bg ON bg.gruppe_id = g.id_gruppe                
            WHERE bg.benutzer_id = '$id' ORDER BY a.startzeit");
        $result = $db->query($sql);
        $db->close();
        return $result;
    }

    function getAllActivityGroupsByActivityID($id){
        $db = getDatabase();
        $sql = ("SELECT * FROM AKTIVITAET_GRUPPE WHERE aktivitaet_id = '$id'");
        $result = $db->query($sql);
        $db->close();
        return $result;
    }

    function getAllCharacteristicsCategories(){
        $db = getDatabase();
        $sql = ("SELECT * FROM STECKBRIEFKATEGORIE");
        $result = $db->query($sql);
        $db->close();
        return $result;
    }

    function getCharacteristicsCategoryByObligation(){
        $db = getDatabase();
        $sql = ("SELECT * FROM STECKBRIEFKATEGORIE WHERE obligation = 1");
        $result = $db->query($sql);
        $db->close();
        return $result;
    }

    function getCharacteristicsCategoriesByID($id){
        $db = getDatabase();
        $sql = ("SELECT * FROM STECKBRIEFKATEGORIE WHERE id_steckbriefkategorie = '$id'");
        $result = $db->query($sql);
        $resultarray = mysqli_fetch_assoc($result);
        $db->close();
        return $resultarray;
    }

    function getCharacteristicsByUserID($id){
        $db = getDatabase();
        $sql = ("SELECT * FROM STECKBRIEF WHERE benutzer_id = '$id'");
        $result = $db->query($sql);
        $db->close();
        return $result;
    }

    function getCharacteristicsByUserIDAndCharacteristicsID($userid, $characteristicsid){
        $db = getDatabase();
        $sql = ("SELECT * FROM STECKBRIEF WHERE benutzer_id = '$userid' AND steckbriefkategorie_id = '$characteristicsid'");
        $result = $db->query($sql);
        $resultarray = mysqli_fetch_assoc($result);
        $db->close();
        return $resultarray;
    }

    function getCharacteristicsByUserIDAndObligation($id){
        $db = getDatabase();
        $sql = ("SELECT sk.id_steckbriefkategorie AS id_steckbriefkategorie, sk.name AS name, sk.obligation AS obligation, sk.einzeiler AS einzeiler, s.antwort AS antwort FROM STECKBRIEFKATEGORIE AS sk 
            JOIN STECKBRIEF AS s ON s.steckbriefkategorie_id=sk.id_steckbriefkategorie 
            WHERE s.benutzer_id = '$id' AND sk.obligation = 0");
        $result = $db->query($sql);
        $db->close();
        return $result;
    }

    function getAllEmergencyCategories(){
        $db = getDatabase();
        $sql = ("SELECT * FROM NOTFALLKATEGORIE");
        $result = $db->query($sql);
        $db->close();
        return $result;
    }

    function getEmergencyCategoryByID($id){
        $db = getDatabase();
        $sql = ("SELECT * FROM NOTFALLKATEGORIE WHERE id_notfallkategorie = '$id'");
        $result = $db->query($sql);
        $resultarray = mysqli_fetch_assoc($result);
        $db->close();
        return $resultarray;
    }

    function getFeedbackCategoryByID($id){
        $db = getDatabase();
        $sql = ("SELECT * FROM FEEDBACKKATEGORIE WHERE id_feedbackkategorie = '$id'");
        $result = $db->query($sql);
        $resultarray = mysqli_fetch_assoc($result);
        $db->close();
        return $resultarray;
    }

    function getAllFeedbackCategories(){
        $db = getDatabase();
        $sql = ("SELECT * FROM FEEDBACKKATEGORIE");
        $result = $db->query($sql);
        $db->close();
        return $result;
    }

    function getLowestFeedbackCategory(){
        $db = getDatabase();
        $sql = ("SELECT MIN(aufschaltszeit) FROM FEEDBACKKATEGORIE");
        $result = $db->query($sql);
        $resultarray = mysqli_fetch_assoc($result);
        $db->close();
        return $resultarray;
    }

    function getAllOptionsByFeedbackID($id){
        $db = getDatabase();
        $sql = ("SELECT * FROM OPTIONEN WHERE feedbackkategorie_id = '$id'");
        $result = $db->query($sql);
        $db->close();
        return $result;
    }

    function getUserFeedbackByOptionIDAndFeedbackCategoryID($oid, $fid){
        $db = getDatabase();
        $sql = ("SELECT * FROM FEEDBACKBOGEN WHERE feedbackkategorie_id = '$fid' AND optionen_id = '$oid'");
        $result = $db->query($sql);
        $db->close();
        return $result;
    }

    function getAllActivityEntities(){
        $db = getDatabase();
        $sql = ("SELECT * FROM AKTIVITAETBLOCK");
        $result = $db->query($sql);
        $db->close();
        return $result;
    }

    function getActivityentityByID($id){
        $db = getDatabase();
        $sql = ("SELECT * FROM AKTIVITAETBLOCK WHERE id_aktivitaetblock = '$id'");
        $result = $db->query($sql);
        $resultarray = mysqli_fetch_assoc($result);
        $db->close();
        return $resultarray;
    }

    function getActivityentityIDByName($name){
        $db = getDatabase();
        $sql = ("SELECT id_aktivitaetblock FROM AKTIVITAETBLOCK WHERE name = '$name'");
        $result = $db->query($sql);
        $resultarray = mysqli_fetch_assoc($result);
        $db->close();
        return $resultarray['id_aktivitaetblock'];
    }

    function getActivityentityNameByID($id){
        $db = getDatabase();
        $sql = ("SELECT * FROM AKTIVITAETBLOCK WHERE id_aktivitaetblock = '$id'");
        $result = $db->query($sql);
        $resultarray = mysqli_fetch_assoc($result);
        $db->close();
        return $resultarray['name'];
    }

    function getActivityentitynameByName($name){
        $db = getDatabase();
        $sql = ("SELECT name FROM AKTIVITAETBLOCK WHERE name = '$name' LIMIT 1");
        $result = $db->query($sql);
        $resultarray = mysqli_fetch_assoc($result);
        $db->close();
        return $resultarray['name'];
    }

    function getActivityentityByArtID($id){
        $db = getDatabase();
        $sql = ("SELECT * FROM AKTIVITAETBLOCK WHERE art_id = '$id'");
        $result = $db->query($sql);
        $db->close();
        return $result;
    }

    function getActivityentitiesByArtID($id){
        $db = getDatabase();
        $sql = ("SELECT * FROM AKTIVITAETBLOCK WHERE art_id = '$id'");
        $result = $db->query($sql);
        $db->close();
        return $result;
    }

    function getCharacteristicsByObligationAndID($id){
        $db = getDatabase();
        $sql = ("SELECT * FROM STECKBRIEF AS s JOIN STECKBRIEFKATEGORIE AS sk ON s.steckbriefkategorie_id = sk.id_steckbriefkategorie WHERE sk.obligation = '0' AND s.benutzer_id = '$id'");
        $result = $db->query($sql);
        $db->close();
        return $result;
    }

    function getWrittenIn($userid, $activityid){
        $db = getDatabase();
        $sql = ("SELECT * FROM EINSCHREIBEN WHERE aktivitaet_id = '$activityid' AND benutzer_id = '$userid'");
        $result = $db->query($sql);
        $resultarray = mysqli_fetch_assoc($result);
        $db->close();
        return $resultarray;
    }

    function getWrittenInByActivityID($activityid){
        $db = getDatabase();
        $sql = ("SELECT * FROM EINSCHREIBEN WHERE aktivitaet_id = '$activityid'");
        $result = $db->query($sql);
        $db->close();
        return $result;
    }

    function getNextActivity($starttime, $activityid, $userid){
        $db = getDatabase();
        $sql = ("SELECT * FROM AKTIVITAET AS a
            JOIN AKTIVITAET_GRUPPE AS ag ON ag.aktivitaet_id = a.id_aktivitaet
            JOIN GRUPPE AS g ON g.id_gruppe = ag.gruppe_id
            JOIN BENUTZER_GRUPPE AS bg ON bg.gruppe_id = g.id_gruppe                
            WHERE bg.benutzer_id = '$userid' AND a.startzeit >= '$starttime' AND a.id_aktivitaet != '$activityid' ORDER BY a.startzeit LIMIT 1");
        $result = $db->query($sql);
        $resultarray = mysqli_fetch_assoc($result);
        $db->close();
        return $resultarray;
    }

    function getActivityBefore($starttime, $activityid, $userid){
        $db = getDatabase();
        $sql = ("SELECT * FROM AKTIVITAET AS a
            JOIN AKTIVITAET_GRUPPE AS ag ON ag.aktivitaet_id = a.id_aktivitaet
            JOIN GRUPPE AS g ON g.id_gruppe = ag.gruppe_id
            JOIN BENUTZER_GRUPPE AS bg ON bg.gruppe_id = g.id_gruppe                
            WHERE bg.benutzer_id = '$userid' AND a.startzeit <= '$starttime' AND a.id_aktivitaet != '$activityid' ORDER BY a.startzeit DESC LIMIT 1");
        $result = $db->query($sql);
        $resultarray = mysqli_fetch_assoc($result);
        $db->close();
        return $resultarray;
    }

    function getActivitiesBeforeASC($starttime, $activityid, $userid){
        $db = getDatabase();
        $sql = ("SELECT * FROM AKTIVITAET AS a
            JOIN AKTIVITAET_GRUPPE AS ag ON ag.aktivitaet_id = a.id_aktivitaet
            JOIN GRUPPE AS g ON g.id_gruppe = ag.gruppe_id
            JOIN BENUTZER_GRUPPE AS bg ON bg.gruppe_id = g.id_gruppe                
            WHERE bg.benutzer_id = '$userid' AND a.startzeit <= '$starttime' AND a.id_aktivitaet != '$activityid' ORDER BY a.startzeit");
        $result = $db->query($sql);
        $db->close();
        return $result;
    }

    function getActivitiesBeforeDESC($starttime, $activityid, $userid){
        $db = getDatabase();
        $sql = ("SELECT * FROM AKTIVITAET AS a
            JOIN AKTIVITAET_GRUPPE AS ag ON ag.aktivitaet_id = a.id_aktivitaet
            JOIN GRUPPE AS g ON g.id_gruppe = ag.gruppe_id
            JOIN BENUTZER_GRUPPE AS bg ON bg.gruppe_id = g.id_gruppe                
            WHERE bg.benutzer_id = '$userid' AND a.startzeit <= '$starttime' AND a.id_aktivitaet != '$activityid' ORDER BY a.startzeit DESC");
        $result = $db->query($sql);
        $db->close();
        return $result;
    }

    function getNextActivities($starttime, $activityid, $userid){
        $db = getDatabase();
        $sql = ("SELECT * FROM AKTIVITAET AS a
            JOIN AKTIVITAET_GRUPPE AS ag ON ag.aktivitaet_id = a.id_aktivitaet
            JOIN GRUPPE AS g ON g.id_gruppe = ag.gruppe_id
            JOIN BENUTZER_GRUPPE AS bg ON bg.gruppe_id = g.id_gruppe                
            WHERE bg.benutzer_id = '$userid' AND a.startzeit >= '$starttime' AND a.id_aktivitaet != '$activityid' ORDER BY a.startzeit");
        $result = $db->query($sql);
        $db->close();
        return $result;
    }

    function getActivityByStartzeitAndID($starttime, $id){
        $db = getDatabase();
        $sql = ("SELECT * FROM AKTIVITAET
            WHERE endzeit > '$starttime' AND id_aktivitaet = '$id'
            ORDER BY startzeit");
        $result = $db->query($sql);
        $db->close();
        return $result;
    }

    function getActivityAndWrittenInByActivityentityIDAndUserID($aeid, $userid){
        $db = getDatabase();
        $sql = ("SELECT e.aktivitaet_id AS aktivitaet_id, a.startzeit AS startzeit FROM AKTIVITAET AS a
            LEFT JOIN EINSCHREIBEN AS e ON e.aktivitaet_id = a.id_aktivitaet 
            JOIN AKTIVITAET_GRUPPE AS ag ON ag.aktivitaet_id = a.id_aktivitaet
            JOIN GRUPPE AS g ON g.id_gruppe = ag.gruppe_id
            JOIN BENUTZER_GRUPPE AS bg ON bg.gruppe_id = g.id_gruppe            
            WHERE bg.benutzer_id = '$userid' AND a.aktivitaetblock_id = '$aeid' AND (e.benutzer_id = '$userid' OR e.benutzer_id IS NULL)");
        $result = $db->query($sql);
        $db->close();
        return $result;
    }

    function getUserFeedbackByFeedbackCategoryID($id, $userid){
        $db = getDatabase();
        $sql = ("SELECT * FROM FEEDBACKBOGEN WHERE feedbackkategorie_id = '$id' AND benutzer_id = '$userid'");
        $result = $db->query($sql);
        $db->close();
        return $result;
    }

    function getUserFeedbackByFeedbackCategoryIDAndBemerkung($id){
        $db = getDatabase();
        $sql = ("SELECT * FROM FEEDBACKBOGEN WHERE feedbackkategorie_id = '$id' AND bemerkung IS NOT NULL");
        $result = $db->query($sql);
        $db->close();
        return $result;
    }

    function getUserFeedbackArrayByFeedbackCategoryID($id, $userid){
        $db = getDatabase();
        $sql = ("SELECT * FROM FEEDBACKBOGEN WHERE feedbackkategorie_id = '$id' AND benutzer_id = '$userid'");
        $result = $db->query($sql);
        $resultarray = mysqli_fetch_assoc($result);
        $db->close();
        return $resultarray;
    }

    function getUserFeedbackCountByFeedbackCategoryID($id){
        $db = getDatabase();
        $sql = ("SELECT COUNT(benutzer_id) AS counted FROM FEEDBACKBOGEN WHERE feedbackkategorie_id = '$id'");
        $result = $db->query($sql);
        $resultarray = mysqli_fetch_assoc($result);
        $db->close();
        return $resultarray;
    }

    function getOptionByOptionIDAndFeedbackcategoryID($oid, $fid){
        $db = getDatabase();
        $sql = ("SELECT * FROM OPTIONEN WHERE id_optionen = '$oid' AND feedbackkategorie_id = '$fid'");
        $result = $db->query($sql);
        $resultarray = mysqli_fetch_assoc($result);
        $db->close();
        return $resultarray;
    }

    function insertUser($username, $password, $name, $prename){
        $db = getDatabase();
        $hash = hash('sha256', $password . $username);
        $preparedquery = $db->prepare("INSERT INTO BENUTZER (id_benutzer, benutzername, passwort, name, vorname) VALUES (NULL,?,?,?,?)");
        $preparedquery->bind_param("ssss", $username, $hash, $name, $prename);
        $preparedquery->execute();
        $db->close();
    }

    function insertGroup($groupname, $level){
        $db = getDatabase();
        $preparedquery = $db->prepare("INSERT INTO GRUPPE (id_gruppe, name, level) VALUES (NULL,?,?)");
        $preparedquery->bind_param("si", $groupname, $level);
        $preparedquery->execute();
        $db->close();
    }

    function insertUserGroup($groupid, $userid){
        $db = getDatabase();
        $preparedquery = $db->prepare("INSERT INTO BENUTZER_GRUPPE (gruppe_id,benutzer_id) VALUES (?,?)");
        $preparedquery->bind_param("ii", $groupid, $userid);
        $preparedquery->execute();
        $db->close();
    }

    function insertArt($artname, $writein){
        $db = getDatabase();
        $preparedquery = $db->prepare("INSERT INTO ART (id_art, name, einschreiben) VALUES (NULL,?,?)");
        $preparedquery->bind_param("si", $artname, $writein);
        $preparedquery->execute();
        $db->close();
    }

    function insertActivity($activityname, $activityentityid, $artid, $meetpoint, $participants, $starttime, $endtime, $info){
        $db = getDatabase();
        $preparedquery = $db->prepare("INSERT INTO AKTIVITAET (id_aktivitaet, aktivitaetsname, aktivitaetblock_id, art_id, treffpunkt, anzahlteilnehmer, startzeit, endzeit, info) VALUES (NULL,?,?,?,?,?,?,?,?)");
        $preparedquery->bind_param("siisisss", $activityname, $activityentityid, $artid, $meetpoint, $participants, $starttime, $endtime, $info);
        $preparedquery->execute();
        $_SESSION['activity_add'] = $db->insert_id;
        $db->close();
    }

    function insertActivityGroup($groupid, $activityid){
        $db = getDatabase();
        $preparedquery = $db->prepare("INSERT INTO AKTIVITAET_GRUPPE (gruppe_id,aktivitaet_id) VALUES (?,?)");
        $preparedquery->bind_param("ii", $groupid, $activityid);
        $preparedquery->execute();
        $db->close();
    }

    function insertCharacteristicsCategory($name, $obligate, $oneliner){
        $db = getDatabase();
        $preparedquery = $db->prepare("INSERT INTO STECKBRIEFKATEGORIE (id_steckbriefkategorie, name, obligation, einzeiler) VALUES (NULL,?,?,?)");
        $preparedquery->bind_param("sii", $name, $obligate, $oneliner);
        $preparedquery->execute();
        return $db->insert_id;
        $db->close();
    }

    function insertEmergencyCategory($name, $info){
        $db = getDatabase();
        $preparedquery = $db->prepare("INSERT INTO NOTFALLKATEGORIE (id_notfallkategorie, name, info) VALUES (NULL,?,?)");
        $preparedquery->bind_param("ss", $name, $info);
        $preparedquery->execute();
        $db->close();
    }

    function insertFeedbackCategory($question, $options, $time){
        $db = getDatabase();
        $preparedquery = $db->prepare("INSERT INTO FEEDBACKKATEGORIE (id_feedbackkategorie, frage, anzahloptionen, aufschaltszeit) VALUES (NULL,?,?,?)");
        $preparedquery->bind_param("sis", $question, $options, $time);
        $preparedquery->execute();
        $_SESSION['feedback_add'] = $db->insert_id;
        $db->close();
    }

    function insertOption($id, $answer){
        $db = getDatabase();
        $preparedquery = $db->prepare("INSERT INTO OPTIONEN (id_optionen, feedbackkategorie_id, antwort) VALUES (NULL,?,?)");
        $preparedquery->bind_param("is", $id, $answer);
        $preparedquery->execute();
        $db->close();
    }

    function insertActivityentity($name, $artid, $writeintime){
        $db = getDatabase();
        $preparedquery = $db->prepare("INSERT INTO AKTIVITAETBLOCK (id_aktivitaetblock, name, art_id, einschreibezeit) VALUES (NULL,?,?,?)");
        $preparedquery->bind_param("sis", $name, $artid, $writeintime);
        $preparedquery->execute();
        $db->close();
    }

    function insertCharacteristics($characteristicsid, $userid, $answer){
        $db = getDatabase();
        $preparedquery = $db->prepare("INSERT INTO STECKBRIEF (steckbriefkategorie_id, benutzer_id, antwort) VALUES (?,?,?)");
        $preparedquery->bind_param("iis", $characteristicsid, $userid, $answer);
        $preparedquery->execute();
        $db->close();
    }

    function insertWritein($userid, $activityid){
        $db = getDatabase();
        $preparedquery = $db->prepare("INSERT INTO EINSCHREIBEN (aktivitaet_id, benutzer_id) VALUES (?,?)");
        $preparedquery->bind_param("ii", $activityid, $userid);
        $preparedquery->execute();
        $db->close();
    }

    function insertUserFeedback($userid, $feedbackid, $optionid, $comment){
        $db = getDatabase();
        $preparedquery = $db->prepare("INSERT INTO FEEDBACKBOGEN(benutzer_id, feedbackkategorie_id, optionen_id, bemerkung) VALUES (?,?,?,?)");
        $preparedquery->bind_param("iiis", $userid, $feedbackid, $optionid, $comment);
        $preparedquery->execute();
        $db->close();
    }

    function deleteUserGroup($groupid, $userid){
        $db = getDatabase();
        $sql = "DELETE FROM BENUTZER_GRUPPE WHERE gruppe_id = '$groupid' AND benutzer_id = '$userid'";
        mysqli_query($db,$sql); 
        $db->close(); 
    }

    function deleteActivityGroup($groupid, $activityid){
        $db = getDatabase();
        $sql = "DELETE FROM AKTIVITAET_GRUPPE WHERE gruppe_id = '$groupid' AND aktivitaet_id = '$activityid'";
        mysqli_query($db,$sql); 
        $db->close(); 
    }

    function deleteUser($userid){
        $db = getDatabase();
        $sql = "DELETE FROM BENUTZER WHERE id_benutzer = '".$userid."'";
        mysqli_query($db,$sql);
        $db->close();
    }

    function deleteAllOptionsByFeedbackID($id){
        $db = getDatabase();
        $sql = "DELETE FROM OPTIONEN WHERE feedbackkategorie_id = '$id'";
        mysqli_query($db,$sql);
        $db->close();
    }

    function deleteSteckbriefkategorieByID($id){
        $db = getDatabase();
        $sql = "DELETE FROM STECKBRIEFKATEGORIE WHERE id_steckbriefkategorie = '$id'";
        mysqli_query($db,$sql);
        $db->close();
    }

    function deleteEmergencyCategoryByID($id){
        $db = getDatabase();
        $sql = "DELETE FROM NOTFALLKATEGORIE WHERE id_notfallkategorie = '$id'";
        mysqli_query($db,$sql);
        $db->close();
    }

    function deleteGroupByID($id){
        $db = getDatabase();
        $sql = "DELETE FROM GRUPPE WHERE id_gruppe = '$id'";
        mysqli_query($db,$sql);
        $db->close();
    }

    function deleteFeedbackCategoryByID($id){
        $db = getDatabase();
        $sql = "DELETE FROM FEEDBACKKATEGORIE WHERE id_feedbackkategorie = '$id'";
        mysqli_query($db,$sql);
        $db->close();
    }

    function deleteArtByID($id){
        $db = getDatabase();
        $sql = "DELETE FROM ART WHERE id_art = '$id'";
        mysqli_query($db,$sql);
        $db->close();
    }

    function deleteActivityByID($id){
        $db = getDatabase();
        $sql = "DELETE FROM AKTIVITAET WHERE id_aktivitaet = '$id'";
        mysqli_query($db,$sql);
        $db->close();
    }

    function deleteActivityentityByID($id){
        $db = getDatabase();
        $sql = "DELETE FROM AKTIVITAETBLOCK WHERE id_aktivitaetblock = '$id'";
        mysqli_query($db,$sql);
        $db->close();
    }

    function deleteCharacteristicsCategoryByID($id){
        $db = getDatabase();
        $sql = "DELETE FROM STECKBRIEFKATEGORIE WHERE id_steckbriefkategorie = '$id'";
        mysqli_query($db,$sql);
        $db->close();
    }

    function updateUserByID($userid, $password, $username, $name, $prename){
        $db = getDatabase();
        $hash = hash('sha256', $password . $username);
        $preparedquery = $db->prepare("UPDATE BENUTZER SET benutzername = ?, passwort = ?, name = ?, vorname = ? WHERE id_benutzer = '$userid'");
        $preparedquery->bind_param("ssss", $username, $hash, $name, $prename);
        $preparedquery->execute();
        $db->close();
    }

    function updateGroupByID($groupid, $groupname, $level){
        $db = getDatabase();
        $preparedquery = $db->prepare("UPDATE GRUPPE SET name = ?, level = ? WHERE id_gruppe = '$groupid'");
        $preparedquery->bind_param("si", $groupname, $level);
        $preparedquery->execute();
        $db->close();
    }

    function updateArtByID($artid, $artname, $writein){
        $db = getDatabase();
        $preparedquery = $db->prepare("UPDATE ART SET name = ?, einschreiben = ? WHERE id_art = '$artid'");
        $preparedquery->bind_param("si", $artname, $writein);
        $preparedquery->execute();
        $db->close();
    }

    function updateActivity($activityid, $activityname, $activityentityid, $artid, $meetpoint, $participants, $starttime, $endtime, $info){
        $db = getDatabase();
        $preparedquery = $db->prepare("UPDATE AKTIVITAET SET aktivitaetsname = ?, aktivitaetblock_id = ?, art_id = ?, treffpunkt = ?, anzahlteilnehmer = ?, startzeit = ?, endzeit = ?, info = ? WHERE id_aktivitaet = '$activityid'");
        $preparedquery->bind_param("siisisss", $activityname, $activityentityid, $artid, $meetpoint, $participants, $starttime, $endtime, $info);
        $preparedquery->execute();
        $db->close();
    }

    function updateCharacteristicsCategory($id, $name, $obligate, $oneliner){
        $db = getDatabase();
        $preparedquery = $db->prepare("UPDATE STECKBRIEFKATEGORIE SET name = ?, obligation = ?, einzeiler = ? WHERE id_steckbriefkategorie = '$id'");
        $preparedquery->bind_param("sii", $name, $obligate, $oneliner);
        $preparedquery->execute();
        $db->close();
    }

    function updateEmergencyCategory($id, $name, $info){
        $db = getDatabase();
        $preparedquery = $db->prepare("UPDATE NOTFALLKATEGORIE SET name = ?, info = ? WHERE id_notfallkategorie = '$id'");
        $preparedquery->bind_param("ss", $name, $info);
        $preparedquery->execute();
        $db->close();
    }

    function updateFeedbackCategory($id, $question, $options, $time){
        $db = getDatabase();
        $preparedquery = $db->prepare("UPDATE FEEDBACKKATEGORIE SET frage = ?, anzahloptionen = ?, aufschaltszeit = ? WHERE id_feedbackkategorie = '$id'");
        $preparedquery->bind_param("sis", $question, $options, $time);
        $preparedquery->execute();
        $db->close();
    }

    function updateActivityentity($id, $name, $artid, $writeintime){
        $db = getDatabase();
        $preparedquery = $db->prepare("UPDATE AKTIVITAETBLOCK SET name = ?, art_id = ?, einschreibezeit = ? WHERE id_aktivitaetblock = '$id'");
        $preparedquery->bind_param("sis", $name, $artid, $writeintime);
        $preparedquery->execute();
        $db->close();
    }

    function updateCharacteristics($characteristicsid, $userid, $answer){
        $db = getDatabase();
        $preparedquery = $db->prepare("UPDATE STECKBRIEF SET antwort = ? WHERE steckbriefkategorie_id = '$characteristicsid' AND benutzer_id = '$userid'");
        $preparedquery->bind_param("s", $answer);
        $preparedquery->execute();
        $db->close();
    }
    
    function resetJumpin(){
        $db = getDatabase();
        $sql1 = "DELETE FROM GRUPPE WHERE name NOT IN ('Admin','Coach')";
        mysqli_query($db,$sql1);
        $sql2 = "DELETE FROM BENUTZER
            WHERE id_benutzer NOT IN(
                SELECT benutzer_id from BENUTZER_GRUPPE
                WHERE gruppe_id IN(
                    SELECT id_gruppe FROM GRUPPE
                    WHERE name IN ('Coach','Admin')
                )
            )
        ;";
        mysqli_query($db,$sql2);
        $sql3 = "DELETE FROM AKTIVITAET";
        mysqli_query($db,$sql3);
        $sql4 = "DELETE FROM STECKBRIEFKATEGORIE WHERE obligation != 1";
        mysqli_query($db,$sql4);
        $sql5 = "DELETE FROM AKTIVITAETBLOCK";
        mysqli_query($db,$sql5);
        $sql6 = "DELETE FROM FEEDBACKBOGEN";
        mysqli_query($db,$sql6);
        $sql7 = "DELETE FROM STECKBRIEF";
        mysqli_query($db,$sql7);
        $db->close();
    }
?>