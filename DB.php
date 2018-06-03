<?php
/**
 * Created by PhpStorm.
 * User: Diana Öller
 * Date: 02.06.2018
 * Time: 09:35
 */
include 'Kundenbestellung.php';
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
            echo "Connected succesfully";
        }
    }
    /**
     * @return Alle Kundenbestellungen aus der Datenbank
     */
    function getKundenbestellungen(){
        $Bestellungen = array();
        $result = $this->dbobject->query("SELECT * FROM Kundenbestellung");
        while ($row = $result->fetch_object()) {
            $bestellung = new Kundenbestellung($row->KundenID, $row->KundenbestellungsID);
            array_push($Bestellungen, $bestellung);
        }
        return $Bestellungen;
    }
}