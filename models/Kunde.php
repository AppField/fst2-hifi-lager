<?php
/**
 * Created by PhpStorm.
 * User: Diana Öller
 * Date: 09.06.2018
 * Time: 13:51
 */

class Kunde{

    public $kundenID;
    public $name;
    public $strasse;
    public $hausnummer;
    public $ort;
    public $plz;

    /**
     * Kunde constructor.
     * @param $kundenID
     * @param $name
     * @param $strasse
     * @param $hausnummer
     * @param $ort
     * @param $plz
     */
    public function __construct($kundenID, $name, $strasse, $hausnummer, $ort, $plz)
    {
        $this->kundenID = $kundenID;
        $this->name = $name;
        $this->strasse = $strasse;
        $this->hausnummer = $hausnummer;
        $this->ort = $ort;
        $this->plz = $plz;
    }


}