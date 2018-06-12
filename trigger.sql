DROP TRIGGER eingangLog;
CREATE TRIGGER eingangLog
  AFTER INSERT ON artikeleingang
  FOR EACH ROW
  INSERT INTO Lagerlog(artikelID, Aenderung, Anzahl, Datum, LieferungsID)
  VALUES(NEW.Artikel_ArtikelID, 'E', NEW.anzahl, CURRENT_TIMESTAMP, NEW.LieferantenLieferungID);
  COMMIT;

INSERT INTO artikeleingang (`Artikel_ArtikelID`,`LieferantenLieferungID`,`Anzahl`)VALUES(3,1,25);

Select * from Lagerlog;
Select * from artikeleingang;

DROP TRIGGER ausgangLog;
CREATE TRIGGER ausgangLog
  AFTER INSERT ON artikelausgang
  FOR EACH ROW
  INSERT INTO Lagerlog(artikelID, Aenderung, Anzahl, Datum, LieferungsID)
  VALUES(NEW.ArtikelID, 'A', NEW.anzahl, CURRENT_TIMESTAMP, NEW.KundenlieferungsID);
  COMMIT;

INSERT INTO artikelausgang (`ArtikelID`,`KundenlieferungsID`,`Anzahl`)VALUES(1,1,2);
INSERT INTO artikelausgang (`ArtikelID`,`KundenlieferungsID`,`Anzahl`)VALUES(2,2,2);
Select * from Lagerlog;
Select * from artikelausgang;
COMMIT;

# trigger auf lagerlog um den Bestand anzupassen
DROP TRIGGER bestandAenderung;
CREATE TRIGGER bestandAenderung
AFTER INSERT ON lagerlog
FOR EACH ROW
  UPDATE ARTIKEL SET Lagerstand =IF(NEW.Aenderung = 'KA',Lagerstand-NEW.anzahl, Lagerstand), Lagerstand =IF(NEW.Aenderung = 'KE',Lagerstand+NEW.anzahl, Lagerstand) WHERE ArtikelID = NEW.artikelID;
COMMIT;

# trigger fuer alten und neuen Lagerstand
DROP TRIGGER bestandAnzeige;
DELIMITER //
CREATE TRIGGER bestandAnzeige
BEFORE INSERT ON lagerlog
FOR EACH ROW
BEGIN
	DECLARE artikelBestand int;
    SELECT lagerstand INTO artikelBestand FROM artikel WHERE artikelID = NEW.ArtikelID;
  SET NEW.alterBestand =  artikelBestand,
      NEW.neuerBestand = IF(NEW.Aenderung = 'KA',NEW.alterBestand - NEW.Anzahl, NEW.neuerBestand),
      NEW.neuerBestand = IF(NEW.Aenderung = 'KE',NEW.alterBestand + NEW.Anzahl, NEW.neuerBestand),
      NEW.neuerBestand = IF(NEW.Aenderung = 'A',NEW.alterBestand - NEW.Anzahl, NEW.neuerBestand),
      NEW.neuerBestand = IF(NEW.Aenderung = 'E',NEW.alterBestand + NEW.Anzahl, NEW.neuerBestand);
END; //
DELIMITER ;

INSERT INTO lagerlog
(`ArtikelID`,`Aenderung`,`Anzahl`,`Datum`,`LieferungsID`)
VALUES (1,'KA',5,CURRENT_TIMESTAMP,000);

select * from lagerlog order by datum desc;
Select * from artikel where artikelID = 1;
