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

# trigger auf lagerlog lieferID = 000 und Aenderung = 'K+A/E'
DROP TRIGGER bestandAenderung;
CREATE TRIGGER bestandAenderung
BEFORE INSERT ON lagerlog
FOR EACH ROW
SET NEW.Aenderung = IF(NEW.LieferungsID = 000 AND NEW.Aenderung != 'K%',CONCAT('K',NEW.Aenderung), NEW.Aenderung);
COMMIT;
