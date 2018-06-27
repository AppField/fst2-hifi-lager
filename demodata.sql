
/*nicht benötigte Statements, da zwar constraints bestehen, diese felder jedoch nullable sind.

INSERT INTO kundenstatus (kundenstatusid) values (0);
delete from kundenstatus;
select * from kundenstatus;
INSERT INTO kundenbewertung (kundenbewertungid) values (0);
delete from kundenbewertung;
select * from kundenbewertung; */

## Befehle wenn möglich immer von oben nach untern durchführen,
## da es sonst zu Problemen mit den Constraints kommen könnte.
## Wert die NULLABLE sind wurden freigelassen, dein einfachkeit halber. 

# Demo Kunden
INSERT INTO KUNDE (KundeID, Name, Mail, Telefon, Strasse) VALUES(1, "Max Mustermann", "muster@mail.com", "123456789", "Musterstraße");
Update Kunde set ortid = 1 where kundeid = 1;
INSERT INTO KUNDE (KundeID, Name, Mail, Telefon, Strasse, OrtId) VALUES(2, "Maria Musterfrau", "mmuster@mail.com", "1234569", "Mustergasse",1);
Select * From kunde;
COMMIT;

# Demo Kundenzahlungsbedingung
INSERT INTO zahlungsbedingungkunde VALUES (1, 'asdf', 1);
SELECT * FROM zahlungsbedingungkunde;
COMMIT;

# Demo Kundenbestellungen
INSERT INTO Kundenbestellung (KundenID, KundenbestellungsID, ZahlungsbedingungKundeID)  VALUES (2, 1, 1);
INSERT INTO Kundenbestellung (KundenID, KundenbestellungsID, ZahlungsbedingungKundeID) VALUES (1, 2, 1);
SELECT * FROM Kundenbestellung;
COMMIT;

# Demo Kundenlieferungen
INSERT INTO Kundenlieferung (KundenlieferungsID, KundenbestellungsID, versanddatum, abgeschlossen) VALUES (1,1, STR_TO_DATE('Wednesday, June 2, 2014', '%W, %M %e, %Y') , FALSE);
INSERT INTO Kundenlieferung (KundenlieferungsID, KundenbestellungsID, versanddatum, abgeschlossen) VALUES (2,2, CURDATE() , FALSE);
SELECT * FROM Kundenlieferung;
COMMIT;

# Demo Lieferantenbestellung
INSERT INTO Lieferantenbestellung (LieferantenbestellungsID, LieferantID, ZahlungsmethodeID) VALUES (1,1,1);
INSERT INTO Lieferantenbestellung (LieferantenbestellungsID, LieferantID, ZahlungsmethodeID) VALUES (2,3,3);
SELECT * FROM Lieferantenbestellung;WHERE LieferantenbestellungsID = 1;
COMMIT;

# Demo Lieferantenlieferung
INSERT INTO Lieferantenlieferungen (lieferantenlieferungID, Eingangsdatum, LieferbestellungsID) VALUES (1, CURDATE(), 1);
INSERT INTO Lieferantenlieferungen (lieferantenlieferungID, Eingangsdatum, LieferbestellungsID) VALUES (2, CURDATE()+1, 2);
SELECT * FROM Lieferantenlieferungen; WHERE LieferbestellungsID = 1;
COMMIT;

# Demo  Lieferantenartikel
INSERT INTO Lieferantenartikel (Anzahl, ArtikelID, LieferantenbestellungsID, LieferantenLieferungID) VALUES (15, 1,1,1);
SELECT Anzahl FROM Lieferantenartikel WHERE LieferantenbestellungsID = 1 AND ArtikelID = 1;
SELECT * FROM Lieferantenartikel;
INSERT INTO Lieferantenartikel (Anzahl, ArtikelID, LieferantenbestellungsID, LieferantenLieferungID) VALUES (15, 3,2,2);
COMMIT;

# Demo Lagerlog
INSERT INTO Lagerlog (ArtikelID, Änderung, Anzahl, Datum, LieferungsID) VALUES (1, 'E', 15, CURDATE(), 1);
SELECT ArtikelID, Änderung, Anzahl, Datum, LieferungsID, Artikelname FROM Lagerlog JOIN Artikel USING(ArtikelID);

SELECT * FROM Lagerlog;
ALTER TABLE Lagerlog CHANGE COLUMN Änderung Aenderung CHAR(1);



###
DELETE FROM Artikeleingang;
SELECT * FROM Lieferantenlieferungen;
UPDATE Lieferantenlieferungen SET LieferbestellungsID = 1 WHERE LieferantenLieferungID = 2;
SELECT * FROM Lieferantenbestellung;
SELECT * FROM Lieferantenartikel;
SELECT * FROM Artikeleingang;
DELETE FROM Artikeleingang;
commit
Insert INTO Artikeleingang Values (1, 2, 2);
UPDATE Artikeleingang SET Anzahl = 2 WHERE Anzahl = 3;

### select für offene Artikel 
SELECT * FROM (SELECT SUM(Anzahl) as Eingegangen ,Artikel_ArtikelID as ArtikelID FROM Artikeleingang JOIN Lieferantenlieferungen USING (LieferantenLieferungID) 
              JOIN Lieferantenbestellung ON (Lieferantenlieferungen.LieferbestellungsID = Lieferantenbestellung.LieferantenbestellungsID)
              WHERE Lieferantenlieferungen.LieferbestellungsID = 1
              GROUP BY(Artikel_ArtikelID)) as Eingangen JOIN
(SELECT Anzahl as Bestellt, ArtikelID FROM Lieferantenartikel WHERE LieferantenbestellungsID = 1 GROUP BY (ArtikelID)) as Bestellt 
  USING(ArtikelID) JOIN Artikel USING (ArtikelID) WHERE Eingegangen < Bestellt; 
  

###
INSERT INTO Artikeleingang (Artikel_ArtikelID, Anzahl, LieferantenLieferungID) VALUES (1,5,1);
SELECT * FROM (SELECT SUM(Artikeleingang.Anzahl) as Eingangen, SUM(Lieferantenartikel.Anzahl) as Bestellt, ArtikelID, LieferantenBestellungsID FROM Artikeleingang 
              JOIN Lieferantenlieferungen USING (LieferantenLieferungID) 
              JOIN Lieferantenbestellung ON (Lieferantenlieferungen.LieferbestellungsID = Lieferantenbestellung.LieferantenbestellungsID) 
              JOIN Lieferantenartikel USING (LieferantenbestellungsID) GROUP BY(Artikel_ArtikelID) AND LieferantenBestellungsID = 3) AS t;
              WHERE Eingangen  Bestellt;  
SELECT * FROM Lieferantenartikel JOIN Lieferantenbestellung USING (LieferantenbestellungsID) WHERE LieferantenbestellungsID = 1;
INSERT INTO Lieferantenartikel (ArtikelID, Anzahl, LieferantenbestellungsID) Values (2, 4, 1);
commit;
SELECT Anzahl as Bestellt, ArtikelID FROM Lieferantenartikel WHERE LieferantenbestellungsID = 1;
SELECT * FROM Artikeleingang;
INSERT INTO Artikeleingang (Artikel_ArtikelID, LieferantenLieferungID, Anzahl) Values (5,3,2);
commit;
SELECT * FROM ARTIKEL;
UPDATE ARTIKEL SET Lagerort = "am Boden" WHERE ArtikelID = 30;
SELECT ArtikelID, Artikelname, (Bestellt-IFNULL(Eingegangen,0)) As Offen FROM (SELECT * FROM (SELECT Anzahl as Bestellt, ArtikelID FROM Lieferantenartikel WHERE LieferantenbestellungsID = 1) as Bestellung Left JOIN
(SELECT SUM(Anzahl) as Eingegangen, Artikel_ArtikelID as ArtikelID FROM Artikeleingang 
JOIN Lieferantenlieferungen USING(LieferantenLieferungID) WHERE LieferbestellungsID = 1 GROUP BY Artikel_ArtikelID) as Lieferung
USING (ArtikelID)) as Results JOIN Artikel USING(ArtikelID) WHERE Eingegangen is null OR Eingegangen < Bestellt;

Select (5-null) from dual;
SELECT * FROM Lagerlog;
DELETE FROM Lagerlog WHERE Aenderung = "A" AND LieferungsID = 0;
COMMIT;

SELECT ArtikelID, Artikelname, (Bestellt-IFNULL(Eingegangen,0)) As Offen FROM (SELECT * FROM (SELECT Anzahl as Bestellt, ArtikelID 
FROM Lieferantenartikel WHERE LieferantenbestellungsID = 1) as Bestellung Left JOIN
(SELECT SUM(Anzahl) as Eingegangen, Artikel_ArtikelID as ArtikelID FROM Artikeleingang 
JOIN Lieferantenlieferungen USING(LieferantenLieferungID) WHERE LieferbestellungsID = 1 GROUP BY Artikel_ArtikelID) as Lieferung
USING (ArtikelID)) as Results JOIN Artikel USING(ArtikelID) WHERE Eingegangen is null OR Eingegangen < Bestellt;

SELECT ArtikelID,Artikelname , (Bestellt-IFNULL(Ausgegangen,0)) As Offen FROM (SELECT * FROM (SELECT Anzahl as Bestellt, ArtikelID 
FROM Auftragsposition WHERE KundenbestellungsID = 1) as Bestellung
LEFT JOIN
(SELECT Anzahl as Ausgegangen, ArtikelID
FROM Artikelausgang JOIN Kundenlieferung USING(KundenlieferungsID) 
JOIN Kundenbestellung USING(KundenbestellungsID) WHERE KundenbestellungsID = 1) as Lieferung USING(ArtikelID)) as Result JOIN Artikel
USING(ArtikelID) WHERE Ausgegangen is null OR Ausgegangen < Bestellt;

SELECT ArtikelID, Artikelname, Einkaufspreis, Verkaufspreis, Mindestbestand, Lagerstand, Lagerort
FROM Auftragsposition JOIN Artikel USING(ArtikelID) WHERE KundenbestellungsID = 1;
SELECT Anzahl FROM Auftragsposition WHERE KundenbestellungsID = 1 AND ArtikelID = 5;
SELECT * FROM Kundenlieferung; WHERE KundenbestellungsID = 1;
SELECT * FROM Lieferantenlieferungen;
INSERT INTO Lieferantenlieferungen VALUES (null, CURDATE(), 1);
DELETE FROM Lieferantenlieferungen WHERE LieferantenLieferungID = 6;
SELECT * FROM Kundenlieferung;
SELECT * FROM Kundenbestellung;
SELECT * FROM Artikelausgang JOIN Kundenlieferung USING(KundenlieferungsID) WHERE KundenlieferunsID = ;
INSERT INTO Artikeleingang Values (;
SELECT * FROM Lieferantenlieferungen; FULL JOIN Artikeleingang USING(LieferantenLieferungID);
commit;
UPDATE Lieferantenbestellung SET abgeschlossen = 1 WHERE LieferantenbestellungsID = 1;
SELECT * FROM Lieferantenbestellung;
SELECT * FROM Kundenlieferung;
INSERT INTO Kundenlieferung (KundenbestellungsID, Versanddatum, Abgeschlossen) Values("", CURDATE(), 0);
SELECT * FROM Artikeleingang JOIN Lieferantenlieferungen USING(LieferantenLieferungID) WHERE LieferantenLieferungID = 1;

SELECT COUNT(*) FROM (SELECT * FROM (SELECT Anzahl as Bestellt, ArtikelID
        FROM Lieferantenartikel WHERE LieferantenbestellungsID = 1) as Bestellung Left JOIN
        (SELECT SUM(Anzahl) as Eingegangen, Artikel_ArtikelID as ArtikelID FROM Artikeleingang
        JOIN Lieferantenlieferungen USING(LieferantenLieferungID) WHERE LieferbestellungsID = 1 GROUP BY Artikel_ArtikelID) as Lieferung
        USING (ArtikelID)) as Results JOIN Artikel USING(ArtikelID) WHERE Eingegangen is null OR Eingegangen < Bestellt;
        
SHOW TRIGGERS;
DROP TRIGGER ausgangLog;

commit
;
SELECT KundenbestellungsID FROM artikelausgang
  JOIN Kundenlieferung USING(KundenlieferungsID) 
  WHERE KundenlieferungsID = 1;

SELECT * FROM artikelausgang;
SELECT Count(*) FROM (SELECT * FROM (SELECT Anzahl as Bestellt, ArtikelID 
        FROM Auftragsposition WHERE KundenbestellungsID = 1) as Bestellung
        LEFT JOIN
        (SELECT Anzahl as Ausgegangen, ArtikelID
        FROM Artikelausgang JOIN Kundenlieferung USING(KundenlieferungsID) 
        JOIN Kundenbestellung USING(KundenbestellungsID) WHERE KundenbestellungsID = 1) as Lieferung USING(ArtikelID)) as Result JOIN Artikel
        USING(ArtikelID)  WHERE Ausgegangen is null OR Ausgegangen < Bestellt;
        

DELIMITER //
CREATE TRIGGER  kundenbestellungAbschliesen
AFTER INSERT ON artikelausgang
FOR EACH ROW
BEGIN
  DECLARE bestellID int;
  DECLARE offeneArtikelCount int;

  INSERT INTO Lagerlog(artikelID, Aenderung, Anzahl, Datum, LieferungsID)
  VALUES(NEW.ArtikelID, 'A', NEW.anzahl, CURRENT_TIMESTAMP, NEW.KundenlieferungsID);

  SELECT KundenbestellungsID INTO bestellID FROM artikelausgang
  JOIN Kundenlieferung USING(KundenlieferungsID)
  WHERE KundenlieferungsID = NEW.KundenlieferungsID;

  SELECT Count(*) INTO offeneArtikelCount FROM (SELECT * FROM (SELECT Anzahl as Bestellt, ArtikelID
        FROM Auftragsposition WHERE KundenbestellungsID = bestellID) as Bestellung
        LEFT JOIN
        (SELECT Anzahl as Ausgegangen, ArtikelID
        FROM Artikelausgang JOIN Kundenlieferung USING(KundenlieferungsID)
        JOIN Kundenbestellung USING(KundenbestellungsID) WHERE KundenbestellungsID = bestellID) as Lieferung USING(ArtikelID)) as Result JOIN Artikel
        USING(ArtikelID)  WHERE Ausgegangen is null OR Ausgegangen < Bestellt;


  IF(offeneArtikelCount = 0, UPDATE Kundenbestellung SET status = 'A' WHERE KundenbestellungsID = bestellID);
END; //
DELIMITER ;
DELETE FROM Lagerlog WHERE Datum < STR_TO_DATE('2018-06-12 14:03:52', '%Y-%m-%d %H:%i:%s');
;
savepoint a;
SELECT * FROM Lagerlog;
commit;
SELECT * FROM Kundenlieferung;
DELETE FROM Kundenlieferung where KundenlieferungsID = 11;
ALTER TABLE auftragsposition ADD Primary Key (KundenbestellungsID);
UPDATE Kundenbestellung SET Status = "O"; WHERE KundenbestellungsID = 3;
SELECT * FROM auftragsposition;
commit;
INSERT INTO auftragsposition (Anzahl, ArtikelID, KundenbestellungsID) VALUES (14, 14, 5);
SELECT * FROM Kundenbestellung; ORDER BY (Abgeschlossen) ASC;
SELECt * FROM lieferant;
SELECT * FROM lagerlog;
SELECT * FROM Kundenlieferung;
DELETE FROM Kundenlieferung WHERE KundenlieferungsID = 18;
DELETE FROM Artikelausgang WHERE KundenlieferungsID = 18;

SELECT * FROM Lieferantenartikel; JOIN Lieferantenlieferungen USING(LieferantenLieferungID);
GROUP By ArtikelID)
####
SELECT SUM(Anzahl) as Bestellt, ArtikelID 
        FROM Lieferantenartikel GROUP By ArtikelID;
SELECT * FROM (SELECT * FROM (SELECT Anzahl as Bestellt, ArtikelID 
        FROM Lieferantenartikel  as Bestellung Left JOIN
        (SELECT SUM(Anzahl) as Eingegangen, Artikel_ArtikelID as ArtikelID FROM Artikeleingang 
        JOIN Lieferantenlieferungen USING(LieferantenLieferungID) GROUP BY Artikel_ArtikelID) as Lieferung
        USING (ArtikelID)) as Results JOIN Artikel USING(ArtikelID)  WHERE Eingegangen is null OR Eingegangen < Bestellt GROUP By ArtikelID;
        
sELECT SUM((Bestellt-IFNULL(Eingegangen,0))) As Offen FROM (SELECT * FROM (SELECT Anzahl as Bestellt, ArtikelID 
        FROM Lieferantenartikel WHERE ArtikelID = 14) as Bestellung Left JOIN
        (SELECT SUM(Anzahl) as Eingegangen, Artikel_ArtikelID as ArtikelID FROM Artikeleingang 
        JOIN Lieferantenlieferungen USING(LieferantenLieferungID) GROUP BY Artikel_ArtikelID) as Lieferung
        USING (ArtikelID)) as Results JOIN Artikel USING(ArtikelID) WHERE Eingegangen is null OR Eingegangen < Bestellt;

SELECT "asdfftw" FROM dual;
dbms_output =;
DELETE FROM KUNDE WHERE KundeID = 10000;
commit;
drop trigger kundenNameUpdate;
INSERT INTO KUNDE (KundeID, Vorname, Nachname,Name, Mail, Telefon, Strasse) VALUES(10000, "Max", "Mustermann","asdf", "muster@mail.com", "123456789", "Musterstraße");
CREATE TRIGGER kundenNameInsert
BEFORE INSERT ON kunde
FOR EACH ROW
  SET New.Name = CONCAT(New.Vorname," ",New.Nachname);
  commit;
SELECT * FROM Kunde;
savepoint a;
rollback to a;
UPDATE Kunde SET Vorname = "Max", Nachname = "Musterfrau" WHERE KundeID = 2;
Update Kunde Set Name="Manfred Dauer";
CREATE TRIGGER kundenNameUpdate
BEFORE UPDATE ON kunde
FOR EACH ROW
  SET New.Name = CONCAT(New.Vorname," ",New.Nachname);
DELeTE FROM Kundenbestellung Where KundenbestellungsId = 17;
UPDATE Kundenbestellung SET Status = "O";
SELECT * FROM Kundenbestellung;
commit;
rollback;
DELETE FROM Lagerlog;
DELETE FROM Artikel WHERE ArtikelID > 55;
INSERT INTO Lagerlog(ArtikelID, Aenderung, Anzahl, Datum, LieferungsId) VALUES (93, "KE", 0, CURDATE(), 0);
SELECT * FROM lagerlog;
