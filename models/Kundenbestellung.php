<?php
/**
 * Created by PhpStorm.
 * User: Diana Öller
 * Date: 02.06.2018
 * Time: 11:17
 */
class Kundenbestellung extends Bestellung {
    public $status;


    public function __construct($bestellungsID, $name, $status)
    {
        $this->bestellungsID = $bestellungsID;
        $this->name = $name;
        $this->status = $status;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        return $this->status = $status;
    }

    /**
     * Kundenbestellung constructor.
     * @param $kundenID
     * @param $bestellungsID

    public function __construct($kundenID, $bestellungsID)
    {
        parent::__construct($kundenID,$bestellungsID);
    }

     */
}