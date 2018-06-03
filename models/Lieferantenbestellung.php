<?php
/**
 * Created by PhpStorm.
 * User: Diana Öller
 * Date: 02.06.2018
 * Time: 10:57
 */
include 'Bestellung.php';
class Lieferantenbestellung extends Bestellung {
    public $zahlungsmethodeID;
    public $bestellschein;

    /**
     * Lieferantenbestellung constructor.
     * @param $bestellschein
     */
    public function __construct($bestellungsid, $lieferantenid, $bestellschein)
    {
        parent::__construct($bestellungsid,$lieferantenid);
        $this->bestellschein = $bestellschein;
    }


}