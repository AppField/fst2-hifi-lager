<?php
/**
 * Created by PhpStorm.
 * User: Diana Öller
 * Date: 02.06.2018
 * Time: 11:20
 */

abstract class Bestellung{
    protected $bestellungsID;
    public $zugeordnet;

    /**
     * Bestellung constructor.
     * @param $bestellungsID
     * @param $zugeordnet
     */
    public function __construct($bestellungsID, $zugeordnet)
    {
        $this->bestellungsID = $bestellungsID;
        $this->zugeordnet = $zugeordnet;
    }


}