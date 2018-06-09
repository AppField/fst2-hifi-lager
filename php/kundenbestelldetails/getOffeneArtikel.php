<?php
/**
 * Created by PhpStorm.
 * User: johannes
 * Date: 07.06.18
 * Time: 18:44
 */
include "../../models/Bestellung.php";
include "../../models/Artikel.php";
include "../../models/Lieferantenbestellung.php";
include "../../models/Lieferung.php";
include "../../models/Lieferantenlieferung.php";
include "../../DB.php";
$db = new DB();
$body = "";
if (isset($_GET["id"])) {
    $Lieferantenartiekl = $db->getOffeneArtikelLieferantenbestellung($_GET["id"]);
    foreach ($Lieferantenartiekl as $artikel) {
        $body .= "<tr align = \"center\">
                            <td class=\"hidden-xs\">" . $artikel->getArtikelID() . "</td>
                            <td>" . $artikel->getArtikelname() . "</td>
                            <td>" . $db->getLieferantenbestellungsArtikelAnzahl($_GET["id"], $artikel->getArtikelID()) . "</td>
                          </tr>";
    }
}

// TEMPLATE FUER OFFENEN ARTIKEL

$template = '<li class="list-group-item d-flex justify-content-between align-items-center"
                draggable="true" data-artikel-id="1" data-artikel-name="Kopfhoerer"
                data-artikel-anzahl="10">
                    Kopfhoerer
                <span class="anzahl-badge badge badge-primary badge-pill">10</span>
            </li>';

echo $body;