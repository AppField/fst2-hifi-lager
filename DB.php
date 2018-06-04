<?php
/**
 * Created by PhpStorm.
 * User: Diana Öller
 * Date: 02.06.2018
 * Time: 09:35
 */
include 'models/Bestellung.php';
include 'models/Lieferantenbestellung.php';
include 'models/Kundenbestellung.php';
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
     * @return Alle Kundenbestellungen aus der Datenbank
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
     * @return Alle Lieferantenbestellungen aus der Datenbank
     */
    function getLieferantenbestellung(){
        $this->doConnect();
        $Bestellungen = array();
        $result = $this->dbobject->query("SELECT * FROM Lieferantenbestellung");
        while ($row = $result->fetch_object()) {
            $bestellung = new Lieferantenbestellung($row->LieferantID, $row->LieferantenbestellungsID);
            array_push($Bestellungen, $bestellung);
        }
        $this->close();
        return $Bestellungen;
    }




}