<?php
/**
 * Created by PhpStorm.
 * User: johannes
 * Date: 07.06.18
 * Time: 18:39
 */
include "../../models/Bestellung.php";
include "../../models/Artikel.php";
include "../../models/Lieferantenbestellung.php";
include "../../models/Lieferung.php";
include "../../models/Lieferantenlieferung.php";
include "../../DB.php";
$body = "";
$db = new DB();
if (isset($_GET["id"])) {
$Lieferantenartiekl = $db->getLieferantenbestellungsArtikel($_GET["id"]);
foreach ($Lieferantenartiekl as $artikel){
    $body .= "<tr align = \"center\">
                            <td class=\"hidden-xs\">".$artikel->getArtikelID()."</td>
                            <td>".$artikel->getArtikelname()."</td>
                            <td>".$db->getLieferantenbestellungsArtikelAnzahl($_GET["id"], $artikel->getArtikelID())."</td>
                          </tr>";
}
echo $body;
