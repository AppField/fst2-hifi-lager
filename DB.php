<?php
/**
 * Created by PhpStorm.
 * User: Diana Öller
 * Date: 02.06.2018
 * Time: 09:35
 */

class DB{
    private $servername="wi-projectdb.technikum-wien.at";
    private $user="s18-bvz2-fst-32";
    private $pwd="DbPass4v032";
    private $dbname="s18-bvz2-fst-30";
    private $dbobject = null;

    /**
     *  Wird verwendet um eine Verbindung zur Datenbank herstellen zu können.
     */
    function doConnect(){
        $this->dbobject = new mysqli($this->servername,$this->user,$this->pwd,$this->dbname);
        if($this->dbobject->connect_error){
            echo "Connection failed: ".$this->dbobject->connect_error;
        }else{
            #echo "Connected succesfully";
        }
    }

    /**
     *  Wird verwendet um eine Verbindung zur Datenbank herstellen zu beenden.
     */
    function close(){
        if($this->dbobject){
            mysqli_close($this->dbobject);
        }
    }

    /**
     * Kundenbestellungen aus der Datenbank
     * @return array of Kundenbestellungen()
     */
    function getKundenbestellungen(){
        $this->doConnect();
        $this->dbobject->query("SET NAMES 'utf8'");
        $Bestellungen = array();
        $result = $this->dbobject->query("SELECT * FROM Kundenbestellung
                                          JOIN kunde ON Kundenbestellung.kundenID = kunde.kundeID");
        while ($row = $result->fetch_object()) {
            $bestellung = new Kundenbestellung($row->KundenbestellungsID,  $row->Name, $row->Status, $row->KundenID);
            array_push($Bestellungen, $bestellung);
        }
        $this->close();
        return $Bestellungen;
    }
    /**
     * @param $id of Kundenbestellungs
     * @return Kundenbestellung|null
     */
    function getKundenbestellungenWithID($id){
        $this->doConnect();
        $this->dbobject->query("SET NAMES 'utf8'");
        $bestellung = null;
        $result = $this->dbobject->query("SELECT * FROM Kundenbestellung
                                          JOIN kunde ON Kundenbestellung.kundenID = kunde.kundeID WHERE KundenbestellungsID = ".$id);
        while ($row = $result->fetch_object()) {
            $bestellung = new Kundenbestellung($row->KundenbestellungsID, $row->Name, $row->Status);
        }
        $this->close();
        return $bestellung;
    }


    function getKundenbestellungsLieferungsTyp($bestellId) {
        $this->doConnect();
        $this->dbobject->query("SET NAMES 'utf8'");

        $result = $this->dbobject->query("SELECT gesamtlieferung FROM kundenbestellung WHERE KundenbestellungsID = " . $bestellId);
        $result = $result->fetch_object();
        $this->close();
        return $result->gesamtlieferung;
    }

    /**
     * @param $id
     * @return array
     */
    function getKundenlieferungenWithBestellungsID($id){
        $this->doConnect();
        $this->dbobject->query("SET NAMES 'utf8'");
        $Lieferungen = array();
        $result = $this->dbobject->query("SELECT * FROM Kundenlieferung WHERE KundenbestellungsID = ".$id);
        while ($row = $result->fetch_object()) {
            $Lieferung = new Kundenlieferung($row->KundenlieferungsID, $row->KundenbestellungsID,$row->Versanddatum);
            array_push($Lieferungen, $Lieferung);
        }
        $this->close();
        return $Lieferungen;
    }

    /**
     * Kundenlieferungen aus der Datenbank
     * @return array of Kundenlieferungen()
     */
    function getKundenlieferungen(){
        $this->doConnect();
        $this->dbobject->query("SET NAMES 'utf8'");
        $Lieferungen = array();
        $result = $this->dbobject->query("SELECT * FROM Kundenlieferung");
        while ($row = $result->fetch_object()) {
            $Lieferung = new Kundenlieferung($row->KundenlieferungsID, $row->KundenbestellungsID,$row->Versanddatum, $row->Lieferschein, $row->Rechnung);
            array_push($Lieferungen, $Lieferung);
        }
        $this->close();
        return $Lieferungen;
    }

    /**
     * @return array of Lieferantenbestellungen()
     */
    function getLieferantenbestellung(){
        $this->doConnect();
        $this->dbobject->query("SET NAMES 'utf8'");
        $Bestellungen = array();
        $result = $this->dbobject->query("SELECT * FROM Lieferantenbestellung
                                          JOIN lieferant USING(lieferantID)");
        while ($row = $result->fetch_object()) {
            $bestellung = new Lieferantenbestellung( $row->LieferantenbestellungsID,
                                                     $row->LieferantID,
                                                     $row->Name,
                                                     $row->abgeschlossen);
            array_push($Bestellungen, $bestellung);
        }
        $this->close();
        return $Bestellungen;
    }

    /**
     * @param $id of Lieferantenbestellung
     * @return Lieferantenbestellung|null
     */
    function getLieferantenbestellungWithID($id){
        $this->doConnect();
        $this->dbobject->query("SET NAMES 'utf8'");
        $bestellung = null;
        $result = $this->dbobject->query("SELECT * FROM Lieferantenbestellung JOIN lieferant USING(lieferantID) WHERE LieferantenbestellungsID = ".$id);
        while ($row = $result->fetch_object()) {
            $bestellung = new Lieferantenbestellung( $row->LieferantenbestellungsID, $row->LieferantID, $row->Name, $row->abgeschlossen);
        }
        $this->close();
        return $bestellung;
    }

    /**
     * liefert alle lieferantenlieferungen aus der Datenbank
     * @return array of lieferantenlieferungen
     */
    function getLieferantenlieferungen(){
        $this->doConnect();
        $this->dbobject->query("SET NAMES 'utf8'");
        $Lieferungen = array();
        $result = $this->dbobject->query("SELECT * FROM Lieferantenlieferungen");
        while ($row = $result->fetch_object()) {
            $Lieferung = new Lieferantenlieferung(  $row->LieferantenLieferungID,
                                                    $row->LieferbestellungsID,
                                                    $row->Eingangsdatum);
            array_push($Lieferungen, $Lieferung);
        }
        $this->close();
        return $Lieferungen;
    }

    /**
     * @param $id
     * @return array
     */
    function getLieferantenlieferungenWithBestellungsID($id){
        $this->doConnect();
        $this->dbobject->query("SET NAMES 'utf8'");
        $Lieferungen = array();
        $result = $this->dbobject->query("SELECT * FROM Lieferantenlieferungen WHERE LieferbestellungsID = ".$id);
        while ($row = $result->fetch_object()) {
            $Lieferung = new Lieferantenlieferung($row->LieferantenLieferungID, $row->LieferbestellungsID,$row->Eingangsdatum);
            array_push($Lieferungen, $Lieferung);
        }
        $this->close();
        return $Lieferungen;
    }
    /**
     * @return Alle Artikel aus der Datenbank
     */
    function getArtikel(){
        $this->doConnect();
        $this->dbobject->query("SET NAMES 'utf8'");
        $artikel = array();
        $result = $this->dbobject->query("SELECT * FROM Artikel");
        while ($row = $result->fetch_object()) {

            $bestellung = new Artikel($row->ArtikelID, $row->Artikelname, $row->Lagerstand,
                $row->Einkaufspreis,
                $row->Verkaufspreis, $row->Mindestbestand, $row->Lagerort);
            array_push($artikel, $bestellung);
        }
        $this->close();
        return $artikel;
    }

    /**
     *
     * @return Artikel aus der Datenbank mit spezifischer ID
     */
    function getArtikelById($artikleID){
        $this->doConnect();
        $this->dbobject->query("SET NAMES 'utf8'");
        $result = $this->dbobject->query("SELECT * FROM Artikel WHERE ArtikelID = " . $artikleID);
        $result = $result->fetch_object();

            $artikel = new Artikel($result->ArtikelID, $result->Artikelname, $result->Lagerstand,
                $result->Einkaufspreis,
                $result->Verkaufspreis, $result->Mindestbestand, $result->Lagerort);

        $this->close();
        return $artikel;
    }

    /**
     * @param $id
     * @return array
     */
    function getLieferantenbestellungsArtikel($id){
        $this->doConnect();
        $this->dbobject->query("SET NAMES 'utf8'");
        $artikel = array();
        $result = $this->dbobject->query("SELECT ArtikelID, Artikelname, Einkaufspreis, Verkaufspreis, Mindestbestand, Lagerstand, Lagerort
                                          FROM Lieferantenartikel JOIN Artikel USING(ArtikelID) WHERE LieferantenbestellungsID = ".$id);
        while ($row = $result->fetch_object()) {
            $bestellung = new Artikel($row->ArtikelID, $row->Artikelname, $row->Lagerstand,
            $row->Einkaufspreis, $row->Verkaufspreis, $row->Mindestbestand, $row->Lagerort);
            array_push($artikel, $bestellung);
        }
        $this->close();
        return $artikel;
    }

    function getLieferantenbestellungsArtikelAnzahl($lid, $aid){
        $this->doConnect();
        $this->dbobject->query("SET NAMES 'utf8'");
        $result = $this->dbobject->query("SELECT Anzahl FROM Lieferantenartikel WHERE LieferantenbestellungsID = ".$lid." AND ArtikelID = ".$aid);
        $artikelanzahl = -1;
        while ($row = $result->fetch_object()) {
            $artikelanzahl =$row->Anzahl;
        }
        $this->close();
        return $artikelanzahl;
    }

    function getLagerlog(){
        $this->doConnect();
        $this->dbobject->query("SET NAMES 'utf8'");
        $result = $this->dbobject->query("SELECT ArtikelID, Aenderung, Anzahl, Datum, LieferungsID, Artikelname, alterBestand, neuerBestand FROM Lagerlog JOIN Artikel USING(ArtikelID) ORDER BY Datum DESC");
        $logArray = array();
        while ($row = $result->fetch_object()) {
            $log = new Lagerlog($row->ArtikelID,$row->Artikelname, $row->Anzahl,
                                $row->LieferungsID, $row->Aenderung, $row->Datum,
                                $row->alterBestand, $row->neuerBestand);
            array_push($logArray, $log);
        }
        $this->close();
        return $logArray;
    }

    function getOffeneArtikelLieferantenbestellung($id){
        $this->doConnect();
        $this->dbobject->query("SET NAMES 'utf8'");
        $artikel = array();
        $result = $this->dbobject->query("SELECT ArtikelID, Artikelname, (Bestellt-IFNULL(Eingegangen,0)) As Offen FROM (SELECT * FROM (SELECT Anzahl as Bestellt, ArtikelID 
        FROM Lieferantenartikel WHERE LieferantenbestellungsID = ".$id.") as Bestellung Left JOIN
        (SELECT SUM(Anzahl) as Eingegangen, Artikel_ArtikelID as ArtikelID FROM Artikeleingang 
        JOIN Lieferantenlieferungen USING(LieferantenLieferungID) WHERE LieferbestellungsID = ".$id." GROUP BY Artikel_ArtikelID) as Lieferung
        USING (ArtikelID)) as Results JOIN Artikel USING(ArtikelID) WHERE Eingegangen is null OR Eingegangen < Bestellt");
        while ($row = $result->fetch_object()) {
            $offener = new OffenerArtikel($row->ArtikelID, $row->Artikelname, $row->Offen);
            array_push($artikel, $offener);
        }
        $this->close();
        return $artikel;
    }

    function getOffeneArtikelKundenbestellung($id){
        $this->doConnect();
        $this->dbobject->query("SET NAMES 'utf8'");
        $artikel = array();
        $result = $this->dbobject->query("    SELECT ArtikelID,Artikelname , (Bestellt-IFNULL(Ausgegangen,0)) As Offen FROM (SELECT * FROM (SELECT Anzahl as Bestellt, ArtikelID
        FROM Auftragsposition WHERE KundenbestellungsID = ".$id.") as Bestellung
        LEFT JOIN
        (SELECT SUM(Anzahl) as Ausgegangen, ArtikelID
        FROM Artikelausgang JOIN Kundenlieferung USING(KundenlieferungsID)
        JOIN Kundenbestellung USING(KundenbestellungsID) WHERE KundenbestellungsID = ".$id." GROUP BY (ArtikelID)) as Lieferung USING(ArtikelID)) as Result JOIN Artikel
        USING(ArtikelID)  WHERE Ausgegangen is null OR Ausgegangen < Bestellt;");

        while ($row = $result->fetch_object()) {
            $offener = new OffenerArtikel($row->ArtikelID, $row->Artikelname, $row->Offen);
            array_push($artikel, $offener);
        }
        $this->close();
        return $artikel;
    }

    /**
     * @return Artikel aus der Datenbank von einer bestimmten Lieferantenlieferung
     */
    function getLieferantenlieferungsArtikel($lieferungsID)
    {
        $this->doConnect();
        $this->dbobject->query("SET NAMES 'utf8'");
        $artikel = array();
        $result = $this->dbobject->query("SELECT ArtikelID, Anzahl, Artikelname FROM Artikeleingang 
JOIN Artikel ON Artikeleingang.Artikel_ArtikelID = Artikel.ArtikelID WHERE LieferantenlieferungID =" . $lieferungsID);
        while ($row = $result->fetch_object()) {
            $lieferung = new Lieferschein($row->ArtikelID, $row->Artikelname, $row->Anzahl);
            array_push($artikel, $lieferung);
        }
        $this->close();
        return $artikel;
    }


    function updateArtikelName($id, $name){
        $this->doConnect();
        $this->dbobject->query("SET NAMES 'utf8'");
        $statement = $this->dbobject->prepare("UPDATE ARTIKEL SET Artikelname = ? WHERE ArtikelID = ?");

        $statement->bind_param("ss", $name, $id);
        $statement->execute();
        if($statement->error){
            return false;
        }
        $this->dbobject->query("commit");
        $this->close();
        return true;
    }

    function updateArtikelLagerort($id, $ort){
        $this->doConnect();
        $this->dbobject->query("SET NAMES 'utf8'");
        $statement = $this->dbobject->prepare("UPDATE ARTIKEL SET Lagerort = ? WHERE ArtikelID = ?");

        $statement->bind_param("ss", $ort, $id);
        $statement->execute();
        if($statement->error){
            return false;
        }
        $this->dbobject->query("commit");
        $this->close();
        return true;
    }

    /**
     * @return Artikel aus der Datenbank von einer bestimmten Kundenlieferung
     */
    function getKundenlieferungsArtikel($lieferungsID){
        $this->doConnect();
        $this->dbobject->query("SET NAMES 'utf8'");
        $artikel = array();
        $result = $this->dbobject->query("SELECT ArtikelID, Anzahl, Artikelname FROM Artikelausgang 
        JOIN Artikel USING(ArtikelID) WHERE KundenlieferungsID = ".$lieferungsID);
        while ($row = $result->fetch_object()) {
            $lieferung = new Lieferschein($row->ArtikelID, $row->Artikelname, $row->Anzahl);
            array_push($artikel, $lieferung);
        }
        $this->close();
        return $artikel;
    }

    function getKundenDetails($id){
        $this->doConnect();
        $this->dbobject->query("SET NAMES 'utf8'");
        $result = $this->dbobject->query("SELECT kunde.Name as Kundenname, KundeID, Strasse, Hausnummer, ort.Bezeichnung as Ort, PLZ
            FROM kundenlieferung 
            JOIN artikelausgang USING(KundenlieferungsID)
            JOIN artikel USING (ArtikelID)
            JOIN kundenbestellung USING(KundenbestellungsID)
            JOIN kunde ON kunde.KundeID= kundenbestellung.KundenID 
            JOIN ort USING(OrtID)
            WHERE KundenlieferungsID =".$id);
        $result = $result->fetch_object();
        $kunde = new Kunde($result->KundeID, $result->Kundenname, $result->Strasse, $result->Hausnummer, $result->Ort, $result->PLZ);
        $this->close();
        return $kunde;

    }

    /**
     * @param $id
     * @return array
     */
    function getKundenbestellungsArtikel($id){
        $this->doConnect();
        $this->dbobject->query("SET NAMES 'utf8'");
        $artikel = array();
        $result = $this->dbobject->query("SELECT ArtikelID, Artikelname, Einkaufspreis, Verkaufspreis, Mindestbestand, Lagerstand, Lagerort
                                          FROM Auftragsposition JOIN Artikel USING(ArtikelID) WHERE KundenbestellungsID = ".$id);
        while ($row = $result->fetch_object()) {
            $bestellung = new Artikel($row->ArtikelID, $row->Artikelname, $row->Lagerstand,
                $row->Einkaufspreis, $row->Verkaufspreis, $row->Mindestbestand, $row->Lagerort);
            array_push($artikel, $bestellung);
        }
        $this->close();
        return $artikel;
    }

    function getKundenArtikelAnzahl($lid, $aid){
        $this->doConnect();
        $this->dbobject->query("SET NAMES 'utf8'");
        $result = $this->dbobject->query("SELECT Anzahl FROM Auftragsposition WHERE KundenbestellungsID = ".$lid." AND ArtikelID = ".$aid);
        $artikelanzahl = -1;
        while ($row = $result->fetch_object()) {
            $artikelanzahl =$row->Anzahl;
        }
        $this->close();
        return $artikelanzahl;
    }

    /**
     * @param $bid
     * @return insert_id
     */
    function createLieferantenLieferung($bid){
        $this->doConnect();
        $this->dbobject->query("SET NAMES 'utf8'");
        $this->dbobject->query("INSERT INTO Lieferantenlieferungen VALUES (null, CURDATE(), ".$bid.")");
        if($this->dbobject->error){
            return false;
        }
        $retID = $this->dbobject->insert_id;
        $this->dbobject->query("commit");
        $this->close();
        return $retID;
    }

    function createArtikeleingang($aid, $anzahl, $lid){
        $this->doConnect();
        $this->dbobject->query("SET NAMES 'utf8'");
        $this->dbobject->query("INSERT INTO Artikeleingang Values (".$aid.", ".$lid.", ".$anzahl.")");
        if($this->dbobject->error){
            return false;
        }
        $this->dbobject->query("commit");
        $this->close();
        return true;
    }

    function createlagerlog($aid, $anzahl, $korrektur){
        $time = 'CURRENT_TIMESTAMP';
        $lieferung = '000';
        $this->doConnect();
        $statement = $this->dbobject->prepare("INSERT INTO Lagerlog (`ArtikelID`,`Aenderung`,`Anzahl`,`Datum`,`LieferungsID`)
                                                VALUES (?, ?, ?, $time, ?)");
        $statement->bind_param("ssss", $aid, $korrektur, $anzahl, $lieferung);
        $statement->execute();
        if($statement->error){
            return false;
        }
        $this->dbobject->query("commit");
        $this->close();
    }

    /**
     * @param $bid
     * @return insert_id
     */
    function createKundenLieferung($bid){
        $this->doConnect();
        $this->dbobject->query("SET NAMES 'utf8'");
        $this->dbobject->query("INSERT INTO Kundenlieferung (KundenbestellungsID, Versanddatum, Abgeschlossen) Values(".$bid." , CURDATE(), 0)");
        if($this->dbobject->error){
            return false;
        }
        $iid = $this->dbobject->insert_id;
        $this->dbobject->query("commit");
        $this->close();
        return $iid;
    }

    function createArtikelausgang($aid, $anzahl, $lid){
        $this->doConnect();
        $this->dbobject->query("SET NAMES 'utf8'");
        $this->dbobject->query("INSERT INTO Artikelausgang (ArtikelID, KundenlieferungsID, Anzahl) Values (".$aid.", ".$lid.", ".$anzahl.")");
        if($this->dbobject->error){
            return false;
        }
        $this->dbobject->query("commit");
        $this->close();
        return true;
    }

    function deleteLieferantenLieferung($lid){
        $this->doConnect();
        $this->dbobject->query("SET NAMES 'utf8'");
        $this->dbobject->query("DELETE FROM Artikeleingang WHERE  LieferantenLieferungID =".$lid.";");
        $this->dbobject->query("DELETE FROM Lieferantenlieferungen WHERE  LieferantenLieferungID =".$lid.";");
        if($this->dbobject->error){
            return false;
        }
        $this->dbobject->query("commit");
        $this->close();
    }

    function deleteKundenLieferung($lid){
        $this->doConnect();
        $this->dbobject->query("SET NAMES 'utf8'");
        $this->dbobject->query("DELETE FROM Artikelausgang WHERE  KundenlieferungsID =".$lid.";");
        $this->dbobject->query("DELETE FROM kundenlieferung WHERE  KundenlieferungsID =".$lid.";");
        if($this->dbobject->error){
            return false;
        }
        $this->dbobject->query("commit");
        $this->close();
    }

    function getOffenerArtikelBestand($aid){
        $this->doConnect();
        $this->dbobject->query("SET NAMES 'utf8'");
        $result = $this->dbobject->query("SELECT Lagerstand FROM Artikel WHERE ArtikelID = ".$aid);
        while ($row = $result->fetch_object()) {
            $artikelbestand =$row->Lagerstand;
        }
        $this->close();
        return $artikelbestand;
    }

    function getDetailedLagerlog($aid){
        $this->doConnect();
        $this->dbobject->query("SET NAMES 'utf8'");
        $result = $this->dbobject->query("SELECT ArtikelID, Aenderung, Anzahl, Datum, LieferungsID, Artikelname, alterBestand, 
                                          neuerBestand FROM Lagerlog JOIN Artikel USING(ArtikelID) 
                                          WHERE ArtikelID = ".$aid."
                                          ORDER BY Datum DESC");
        $logArray = array();
        while ($row = $result->fetch_object()) {
            $log = new Lagerlog($row->ArtikelID,$row->Artikelname, $row->Anzahl,
                $row->LieferungsID, $row->Aenderung, $row->Datum,
                $row->alterBestand, $row->neuerBestand);
            array_push($logArray, $log);
        }
        $this->close();
        return $logArray;
    }
    /*    function updateLagerstand($id, $lagerstand){
            $this->doConnect();
            $this->dbobject->query("SET NAMES 'utf8'");
            $statement = $this->dbobject->prepare("UPDATE ARTIKEL SET lagerstand = ? WHERE ArtikelID = ?");
            $query = "INSERT INTO Lagerlog (`ArtikelID`,`Aenderung`,`Anzahl`,`Datum`,`LieferungsID`)
                      VALUES ($aid, $korrektur, $anzahl, $time, '000');";
            $statement->bind_param("ss", $lagerstand, $id);
            $statement->execute();
            if($statement->error){
                return false;
            }
            $this->dbobject->query("commit");
            return true;
        }*/


}