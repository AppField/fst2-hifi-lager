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
include "../../models/OffenerArtikel.php";
include "../../DB.php";
$db = new DB();
$body = "";
if (isset($_GET["id"])) {
    $Lieferantenartiekl = $db->getOffeneArtikelLieferantenbestellung($_GET["id"]);
    foreach ($Lieferantenartiekl as $artikel) {
        $body .= "<tr align = \"center\">
                    <td class=\"hidden-xs\">".$artikel->getID()."</td>
                    <td>".$artikel->getBezeichnung()."</td>
                    <td>".$artikel->getAnzahl()."</td>
                  </tr>";
//        $body .= '<li class="list-group-item d-flex justify-content-between align-items-center"
//                draggable="true" data-artikel-id="' . $artikel->getID() . '" data-artikel-name="' . $artikel->getBezeichnung() . '"
//                data-artikel-anzahl="' . $artikel->getAnzahl() . '">
//                    ' . $artikel->getBezeichnung() . '
//                <span class="anzahl-badge badge badge-primary badge-pill">' . $artikel->getAnzahl() . '</span>
//            </li>';
    }
}


echo $body;