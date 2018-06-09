<?php
/**
 * Created by PhpStorm.
 * User: Diana Öller
 * Date: 09.06.2018
 * Time: 13:22
 */

class Lieferschein{
    public $artikelID;
    public $bezeichnung;
    public $menge;

    /**
     * Lieferschein constructor.
     * @param $artikelID
     * @param $bezeichnung
     * @param $menge
     */
    public function __construct($artikelID, $bezeichnung, $menge)
    {
        $this->artikelID = $artikelID;
        $this->bezeichnung = $bezeichnung;
        $this->menge = $menge;
    }

    /**
     * @return mixed
     */
    public function getArtikelID()
    {
        return $this->artikelID;
    }

    /**
     * @param mixed $artikelID
     */
    public function setArtikelID($artikelID)
    {
        $this->artikelID = $artikelID;
    }

    /**
     * @return mixed
     */
    public function getBezeichnung()
    {
        return $this->bezeichnung;
    }

    /**
     * @param mixed $bezeichnung
     */
    public function setBezeichnung($bezeichnung)
    {
        $this->bezeichnung = $bezeichnung;
    }

    /**
     * @return mixed
     */
    public function getMenge()
    {
        return $this->menge;
    }

    /**
     * @param mixed $menge
     */
    public function setMenge($menge)
    {
        $this->menge = $menge;
    }




}