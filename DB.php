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
        $Bestellungen = array();
        $result = $this->dbobject->query("SELECT * FROM Kundenbestellung");
        while ($row = $result->fetch_object()) {
            $bestellung = new Kundenbestellung($row->KundenID, $row->KundenbestellungsID);
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
        $Bestellungen = array();
        $result = $this->dbobject->query("SELECT * FROM Lieferantenbestellung");
        while ($row = $result->fetch_object()) {
            $bestellung = new Lieferantenbestellung( $row->LieferantenbestellungsID, $row->LieferantID);
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
        $bestellung = null;
        $result = $this->dbobject->query("SELECT * FROM Lieferantenbestellung WHERE LieferantenbestellungsID = ".$id);
        while ($row = $result->fetch_object()) {
            $bestellung = new Lieferantenbestellung( $row->LieferantenbestellungsID, $row->LieferantID);
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
        $Lieferungen = array();
        $result = $this->dbobject->query("SELECT * FROM Lieferantenlieferungen");
        while ($row = $result->fetch_object()) {
            $Lieferung = new Lieferantenlieferung($row->LieferantenLieferungID, $row->LieferbestellungsID,$row->Eingangsdatum, $row->Lieferschein);
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
        $Lieferungen = array();
        $result = $this->dbobject->query("SELECT * FROM Lieferantenlieferungen WHERE LieferbestellungsID = ".$id);
        while ($row = $result->fetch_object()) {
            $Lieferung = new Lieferantenlieferung($row->LieferantenLieferungID, $row->LieferbestellungsID,$row->Eingangsdatum, $row->Lieferschein);
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
     * @param $id
     * @return array
     */
    function getLieferantenbestellungsArtikel($id){
        $this->doConnect();
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

}