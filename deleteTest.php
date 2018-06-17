<?php
/**
 * Created by PhpStorm.
 * User: astan
 * Date: 17.06.2018
 * Time: 17:06
 */
include 'DB.php';
include 'models/Lieferung.php';
include 'models/Bestellung.php';
include 'models/Lieferantenbestellung.php';
include "models/Lieferantenlieferung.php";
include 'models/Kundenbestellung.php';
include "models/Kundenlieferung.php";
include 'models/Artikel.php';
include 'models/Lieferschein.php';
include 'models/Kunde.php';


$db = new DB();
echo 'Kundenlieferung DELETE: <p>';
$db->deleteKundenLieferung(19);
$kundenbestellungen = $db->getKundenlieferungenWithBestellungsID(19);
var_dump($kundenbestellungen);