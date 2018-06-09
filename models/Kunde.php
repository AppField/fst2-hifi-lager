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

    /**
     * Kunde constructor.
     * @param $kundenID
     * @param $name
     * @param $strasse
     * @param $hausnummer
     * @param $ort
     */
    public function __construct($kundenID, $name, $strasse, $hausnummer, $ort)
    {
        $this->kundenID = $kundenID;
        $this->name = $name;
        $this->strasse = $strasse;
        $this->hausnummer = $hausnummer;
        $this->ort = $ort;
    }


}