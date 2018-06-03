<?php
/**
 * Created by PhpStorm.
 * User: Diana Öller
 * Date: 02.06.2018
 * Time: 10:41
 */
include 'Lieferung.php';
class Kundenlieferung extends Lieferung {
    public $uebernahmeschein=null;
    public $rechnung;
    public $abgeschlossen;

    /**
     * Kundenlieferung constructor.
     * @param $uebernahmeschein
     * @param $rechnung
     * @param $abgeschlossen
     */
    public function __construct($lieferungsID,$bestellungsID,$datum,$lieferschein,$rechnung)
    {
        parent::__construct($lieferungsID,$bestellungsID,$datum,$lieferschein);
        //$this->uebernahmeschein = $uebernahmeschein;
        $this->rechnung = $rechnung;
        $this->abgeschlossen = false;
    }



}