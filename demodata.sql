
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
Insert INTO Artikeleingang Values (1, 2, 2);
UPDATE Artikeleingang SET Anzahl = 2;

### select für offene Artikel 
SELECT * FROM (SELECT SUM(Anzahl) as Eingegangen ,Artikel_ArtikelID as ArtikelID FROM Artikeleingang JOIN Lieferantenlieferungen USING (LieferantenLieferungID) 
              JOIN Lieferantenbestellung ON (Lieferantenlieferungen.LieferbestellungsID = Lieferantenbestellung.LieferantenbestellungsID)
              WHERE Lieferantenlieferungen.LieferbestellungsID = 1
              GROUP BY(Artikel_ArtikelID)) as Eingangen JOIN
(SELECT SUM(Anzahl) as Bestellt, ArtikelID FROM Lieferantenartikel WHERE LieferantenbestellungsID = 1 GROUP BY (ArtikelID)) as Bestellt 
  USING(ArtikelID) JOIN Artikel USING (ArtikelID) WHERE Eingegangen < Bestellt; 
  

###
INSERT INTO Artikeleingang (Artikel_ArtikelID, Anzahl, LieferantenLieferungID) VALUES (1,5,1);
SELECT * FROM (SELECT SUM(Artikeleingang.Anzahl) as Eingangen, SUM(Lieferantenartikel.Anzahl) as Bestellt, ArtikelID, LieferantenBestellungsID FROM Artikeleingang 
              JOIN Lieferantenlieferungen USING (LieferantenLieferungID) 
              JOIN Lieferantenbestellung ON (Lieferantenlieferungen.LieferbestellungsID = Lieferantenbestellung.LieferantenbestellungsID) 
              JOIN Lieferantenartikel USING (LieferantenbestellungsID) GROUP BY(Artikel_ArtikelID) AND LieferantenBestellungsID = 1) AS t
              WHERE Eingangen < Bestellt;  
SELECT * FROM Lieferantenartikel JOIN Lieferantenbestellung USING (LieferantenbestellungsID) WHERE LieferantenbestellungsID = 1;
