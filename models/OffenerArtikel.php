<?php
/**
 * Created by PhpStorm.
 * User: johannes
 * Date: 09.06.18
 * Time: 23:37
 */

class OffenerArtikel
{
    public $id;
    public $bezeichnung;
    public $anzahl;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getBezeichnung()
    {
        return $this->bezeichnung;
    }

    /**
     * @return mixed
     */
    public function getAnzahl()
    {
        return $this->anzahl;
    }

    /**
     * OffenerArtikel constructor.
     * @param $id
     * @param $bezeichnung
     * @param $anzahl
     * @param $lagerstand
     */
    public function __construct($id, $bezeichnung, $anzahl)
    {
        $this->id = $id;
        $this->bezeichnung = $bezeichnung;
        $this->anzahl = $anzahl;
    }

}