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
    $kundenartikel = $db->getOffeneArtikelKundenbestellung($_GET["id"]);

    foreach ($kundenartikel as $artikel) {

        $id = $artikel->getID();
        $bestellt = $artikel->getAnzahl();
        $lagerstand = $db->getOffenerArtikelBestand($id);

        if($bestellt < $lagerstand){
            $verfuegbar = "<i class=\"fa fa-check\" style='color: mediumseagreen'></i>";
        }else{
            $verfuegbar = "<i class=\"fa fa-times\" style='color: crimson'></i>";
        }

        $body .= "<tr align = \"center\">
                    <td class=\"hidden-xs\">" . $artikel->getID() . "</td>
                    <td>" . $artikel->getBezeichnung() . "</td>
                    <td>" . $artikel->getAnzahl() . "</td>
                    <td>" . $verfuegbar ."</td>
                  </tr>";
    }
}

echo $body;