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
                                          JOIN kunde ON Kundenbestellung.kundenID = kunde.kundeID;");
        while ($row = $result->fetch_object()) {
            $bestellung = new Kundenbestellung($row->KundenID, $row->KundenbestellungsID, $row->Name);
            array_push($Bestellungen, $bestellung);
        }
        $this->close();
        return $Bestellungen;
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
            $bestellung = new Lieferantenbestellung( $row->LieferantenbestellungsID, $row->LieferantID, $row->Name);
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
        $result = $this->dbobject->query("SELECT * FROM Lieferantenbestellung WHERE LieferantenbestellungsID = ".$id."JOIN lieferant USING(lieferantID)");
        while ($row = $result->fetch_object()) {
            $bestellung = new Lieferantenbestellung( $row->LieferantenbestellungsID, $row->LieferantID, $row->Name);
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
            $Lieferung = new Lieferantenlieferung($row->LieferantenLieferungID, $row->LieferbestellungsID,$row->Eingangsdatum);
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
        $result = $this->dbobject->query("SELECT ArtikelID, Aenderung, Anzahl, Datum, LieferungsID, Artikelname FROM Lagerlog JOIN Artikel USING(ArtikelID)");
        $logArray = array();
        while ($row = $result->fetch_object()) {
            $log = new Lagerlog($row->ArtikelID,$row->Artikelname, $row->Anzahl, $row->LieferungsID, $row->Aenderung, $row->Datum);
            array_push($logArray, $log);
        }
        return $logArray;
    }

    function getOffeneArtikelLieferantenbestellung($id){
        $this->doConnect();
        $this->dbobject->query("SET NAMES 'utf8'");
        $artikel = array();
        $result = $this->dbobject->query("SELECT * FROM (SELECT SUM(Anzahl) as Eingegangen ,Artikel_ArtikelID as ArtikelID FROM Artikeleingang 
              JOIN Lieferantenlieferungen USING (LieferantenLieferungID) 
              JOIN Lieferantenbestellung ON (Lieferantenlieferungen.LieferbestellungsID = Lieferantenbestellung.LieferantenbestellungsID)
              WHERE Lieferantenlieferungen.LieferbestellungsID = ".$id."
              GROUP BY(Artikel_ArtikelID)) as Eingangen JOIN
              (SELECT SUM(Anzahl) as Bestellt, ArtikelID FROM Lieferantenartikel WHERE LieferantenbestellungsID = ".$id." GROUP BY (ArtikelID)) as Bestellt 
              USING(ArtikelID) JOIN Artikel USING (ArtikelID) WHERE Eingegangen < Bestellt");
        while ($row = $result->fetch_object()) {
            $bestellung = new Artikel($row->ArtikelID, $row->Artikelname, $row->Lagerstand,
                $row->Einkaufspreis, $row->Verkaufspreis, $row->Mindestbestand, $row->Lagerort);
            array_push($artikel, $bestellung);
        }
        $this->close();
        return $artikel;
    }
}