<?php
/**
 * Created by PhpStorm.
 * User: Diana Öller
 * Date: 02.06.2018
 * Time: 10:22
 */

class Artikel{
    protected $artikelID=null;

    /**
     * @return null
     */
    public function getArtikelID()
    {
        return $this->artikelID;
    }

    /**
     * @return null
     */
    public function getArtikelname()
    {
        return $this->artikelname;
    }

    /**
     * @return null
     */
    public function getLagerstand()
    {
        return $this->lagerstand;
    }

    /**
     * @return null
     */

    public $artikelname=null;
    public $lagerstand=null;
    public $einkaufspreis=null;
    public $verkaufspreis=null;
    public $mindestbestand=null;
    public $aufschlag = null;

    public $lagerort = null;

    /**
     * @return null
     */
    public function getLagerort()
    {
        return $this->lagerort;
    }
    /**
     * Artikel constructor.
     * @param $artikelID
     * @param $artikelname
     * @param $lagerbestandAktuel
     * @param $lagerbestandVerfuegbar
     * @param $einkaufspreis
     * @param $verkaufspreis
     * @param $mindestbestand
     */
    public function __construct($artikelID, $artikelname, $lagerstand, $einkaufspreis, $verkaufspreis, $mindestbestand, $lagerort)
    {
        $this->artikelID = $artikelID;
        $this->artikelname = $artikelname;
        $this->lagerstand = $lagerstand;
        $this->einkaufspreis = $einkaufspreis;
        $this->verkaufspreis = $verkaufspreis;
        $this->mindestbestand = $mindestbestand;
        $this->lagerort = $lagerort;
    }


}