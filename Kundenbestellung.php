<?php
/**
 * Created by PhpStorm.
 * User: Diana Öller
 * Date: 02.06.2018
 * Time: 11:17
 */

class Kundenbestellung extends Bestellung {


    /**
     * Kundenbestellung constructor.
     * @param $kundenID
     * @param $bestellungsID
     */
    public function __construct($kundenID, $bestellungsID)
    {
        parent::__construct($kundenID,$bestellungsID);
    }


}