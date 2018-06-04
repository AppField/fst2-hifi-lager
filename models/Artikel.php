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
    public function getLagerbestandAktuel()
    {
        return $this->lagerbestandAktuel;
    }

    /**
     * @return null
     */
    public function getLagerbestandVerfuegbar()
    {
        return $this->lagerbestandVerfuegbar;
    }
    public $artikelname=null;
    public $lagerbestandAktuel=null;
    public $lagerbestandVerfuegbar=null;
    public $einkaufspreis=null;
    public $verkaufspreis=null;
    public $mindestbestand=null;
    public $aufschlag = null;
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
    public function __construct($artikelID, $artikelname, $lagerbestandAktuel, $lagerbestandVerfuegbar, $einkaufspreis, $verkaufspreis, $mindestbestand)
    {
        $this->artikelID = $artikelID;
        $this->artikelname = $artikelname;
        $this->lagerbestandAktuel = $lagerbestandAktuel;
        $this->lagerbestandVerfuegbar = $lagerbestandVerfuegbar;
        $this->einkaufspreis = $einkaufspreis;
        $this->verkaufspreis = $verkaufspreis;
        $this->mindestbestand = $mindestbestand;
    }


}