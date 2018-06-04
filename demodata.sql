
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

# Demo Kundenbestellungen
INSERT INTO Kundenbestellung (KundenID, KundenbestellungsID) VALUES (2, 1);
INSERT INTO Kundenbestellung (KundenID, KundenbestellungsID) VALUES (1, 2);
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
SELECT * FROM Lieferantenbestellung;
COMMIT;

# Demo Lieferantenlieferung
INSERT INTO Lieferantenlieferungen (lieferantenlieferungID, Eingangsdatum, LieferbestellungsID) VALUES (1, CURDATE(), 1);
INSERT INTO Lieferantenlieferungen (lieferantenlieferungID, Eingangsdatum, LieferbestellungsID) VALUES (2, CURDATE()+1, 2);
SELECT * FROM Lieferantenlieferungen;
COMMIT;

# Artikel
SELECT * FROM Artikel;
