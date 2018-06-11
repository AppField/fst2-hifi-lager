<?php
/**
 * Created by PhpStorm.
 * User: astan
 * Date: 11.06.2018
 * Time: 14:20
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
include 'models/Lagerlog.php';

$db = new DB();

echo '<p>Lagerlog eintrag</p>';
//$in = $db->createlagerlogTest();
$in = $db->createlagerlog(1,10,'KE');

$eintrag = $db->getLagerlog();

var_dump($eintrag);
