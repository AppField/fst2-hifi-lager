
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

# Demo Bestellungen
INSERT INTO Kundenbestellung (KundenID, KundenbestellungsID) VALUES (2, 1);
INSERT INTO Kundenbestellung (KundenID, KundenbestellungsID) VALUES (1, 2);
SELECT * FROM Kundenbestellung;
COMMIT;

# 
