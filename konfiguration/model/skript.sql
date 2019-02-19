CREATE DATABASE JumpIn;

USE JumpIn;

CREATE TABLE GRUPPE(
    id_gruppe INT AUTO_INCREMENT,
    name VARCHAR(30),
    level INT,
    PRIMARY KEY (id_gruppe)
);

CREATE TABLE BENUTZER(
    id_benutzer INT AUTO_INCREMENT,
    benutzername VARCHAR(30),
    passwort VARCHAR(250),
    name VARCHAR(50),
    vorname VARCHAR(50),
    PRIMARY KEY (id_benutzer)
);

CREATE TABLE BENUTZER_GRUPPE(
    gruppe_id INT,
    benutzer_id INT,
    PRIMARY KEY (gruppe_id, benutzer_id),
    FOREIGN KEY (gruppe_id)
        REFERENCES GRUPPE(id_gruppe)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (benutzer_id)
        REFERENCES BENUTZER(id_benutzer)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE ART(
    id_art INT AUTO_INCREMENT,
    name VARCHAR(30),
    einschreiben TINYINT,
    PRIMARY KEY (id_art)
);

CREATE TABLE AKTIVITAETBLOCK(
    id_aktivitaetblock INT AUTO_INCREMENT,
    name VARCHAR(30),
    art_id INT,
    einschreibezeit DATETIME,
    PRIMARY KEY (id_aktivitaetblock),
    FOREIGN KEY (art_id)
        REFERENCES ART(id_art)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE AKTIVITAET(
    id_aktivitaet INT AUTO_INCREMENT,
    aktivitaetsname VARCHAR(30),
    aktivitaetblock_id INT,
    art_id INT,
    treffpunkt VARCHAR(30),
    anzahlteilnehmer INT,
    startzeit DATETIME,
    endzeit DATETIME,
    info VARCHAR(500),
    PRIMARY KEY (id_aktivitaet),
    FOREIGN KEY (aktivitaetblock_id)
        REFERENCES AKTIVITAETBLOCK(id_aktivitaetblock)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (art_id)
        REFERENCES ART(id_art)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE AKTIVITAET_GRUPPE(
    gruppe_id INT,
    aktivitaet_id INT,
    PRIMARY KEY (gruppe_id, aktivitaet_id),
    FOREIGN KEY (gruppe_id)
        REFERENCES GRUPPE(id_gruppe)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (aktivitaet_id)
        REFERENCES AKTIVITAET(id_aktivitaet)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE NOTFALLKATEGORIE(
    id_notfallkategorie INT AUTO_INCREMENT,
    name VARCHAR(30),
    info VARCHAR(300),
    PRIMARY KEY (id_notfallkategorie)
);

CREATE TABLE STECKBRIEFKATEGORIE(
    id_steckbriefkategorie INT AUTO_INCREMENT,
    name VARCHAR(30),
    obligation TINYINT,
    einzeiler TINYINT,
    PRIMARY KEY (id_steckbriefkategorie)
);

CREATE TABLE STECKBRIEF(
    steckbriefkategorie_id INT,
    benutzer_id INT,
    antwort VARCHAR(300),
    PRIMARY KEY (steckbriefkategorie_id, benutzer_id),
    FOREIGN KEY (steckbriefkategorie_id)
        REFERENCES STECKBRIEFKATEGORIE(id_steckbriefkategorie)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (benutzer_id)
        REFERENCES BENUTZER(id_benutzer)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE EINSCHREIBEN(
    aktivitaet_id INT,
    benutzer_id INT,
    PRIMARY KEY (aktivitaet_id, benutzer_id),
    FOREIGN KEY (aktivitaet_id)
        REFERENCES AKTIVITAET(id_aktivitaet)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (benutzer_id)
        REFERENCES BENUTZER(id_benutzer)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE FEEDBACKKATEGORIE(
    id_feedbackkategorie INT AUTO_INCREMENT,
    frage VARCHAR(300),
    anzahloptionen INT,
    aufschaltszeit DATETIME,
    PRIMARY KEY (id_feedbackkategorie)
);

CREATE TABLE OPTIONEN(
    id_optionen INT AUTO_INCREMENT,
    feedbackkategorie_id INT,
    antwort VARCHAR(300),
    PRIMARY KEY (id_optionen),
    FOREIGN KEY (feedbackkategorie_id)
        REFERENCES FEEDBACKKATEGORIE(id_feedbackkategorie)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE FEEDBACKBOGEN(
    benutzer_id INT,
    feedbackkategorie_id INT,
    optionen_id INT,
    bemerkung VARCHAR(500),
    PRIMARY KEY (benutzer_id, feedbackkategorie_id),
    FOREIGN KEY (optionen_id)
        REFERENCES OPTIONEN(id_optionen)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (benutzer_id)
        REFERENCES BENUTZER(id_benutzer)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (feedbackkategorie_id)
        REFERENCES FEEDBACKKATEGORIE(id_feedbackkategorie)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

INSERT INTO BENUTZER VALUES
(NULL, "admin", "7d8d2c35c7dc2d9e3d9d3dfc73d1d2a2115fcea8e48019ccb4b2dc146650928d", "Admin", "Grande");

INSERT INTO GRUPPE VALUES
(NULL, "Alle", 0),
(NULL, "Admin", 0),
(NULL, "Coach", 3),
(NULL, "Informatiker", 1),
(NULL, "Mediamatiker", 1),
(NULL, "Informatiker EFZ", 2),
(NULL, "Informatiker PiBS", 2),
(NULL, "Informatiker WayUp", 2),
(NULL, "Hilfscoach", 3);

INSERT INTO BENUTZER_GRUPPE VALUES
(2,1);