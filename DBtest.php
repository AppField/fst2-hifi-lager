<?php

include 'DB.php';
/**
 * Created by PhpStorm.
 * User: Diana Öller
 * Date: 02.06.2018
 * Time: 09:49
 */
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
echo 'Kundenbestellungen <p>';
$kundenbestellungen = $db->getKundenbestellungen();
var_dump($kundenbestellungen);
echo '</p>Kundenlieferungen <p>';
$kundenlieferungen = $db->getKundenlieferungen();
var_dump($kundenlieferungen);
echo '</p>Lieferantenbestelllungen <p>';
$lieferantenbestellungen = $db->getLieferantenbestellung();
var_dump($lieferantenbestellungen);
echo '</p>Lieferantenlieferungen <p>';
$lieferantenlieferungen = $db->getLieferantenlieferungen();
var_dump($lieferantenlieferungen);
echo '</p>Artikel <p>';
$artikel = $db->getArtikel();
var_dump($artikel);


echo '</br>';

echo $db->updateArtikelName(999, "asdf");

echo '<br>';
echo '<p>Artikel für Lieferschein</p>';
$lieferungsartikel = $db->getKundenlieferungsArtikel(1);
var_dump($lieferungsartikel);

echo '<br>';
echo '<p>Kunde für Lieferschein</p>';
$kunde = $db->getKundenDetails(1);
var_dump($kunde);