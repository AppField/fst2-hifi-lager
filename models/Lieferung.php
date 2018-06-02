<?php
/**
 * Created by PhpStorm.
 * User: Diana Öller
 * Date: 02.06.2018
 * Time: 10:31
 */

abstract class Lieferung{
    protected $lieferungsID;
    public $bestellungsID;
    public $datum;
    public $lieferschein;

    /**
     * Lieferung constructor.
     * @param $lieferungsID
     * @param $bestellungsID
     * @param $datum
     * @param $lieferschein
     */
    public function __construct($lieferungsID, $bestellungsID, $datum, $lieferschein)
    {
        $this->lieferungsID = $lieferungsID;
        $this->bestellungsID = $bestellungsID;
        $this->datum = $datum;
        $this->lieferschein = $lieferschein;
    }


}