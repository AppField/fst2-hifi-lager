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
include "../../models/Kundenlieferung.php";
include "../../DB.php";
$db = new DB();
$body = "";
if (isset($_GET["id"])) {
    $Lieferantenlieferungen = $db->getKundenlieferungenWithBestellungsID($_GET["id"]);
    foreach ($Lieferantenlieferungen as $lieferung) {
        $body .= " <tr align = \"center\">
                            <td class=\"hidden-xs\">" . $lieferung->getLieferungsID() . "</td>
                            <td>" . $lieferung->getDatum() . "</td>
                               <td><button data-lieferung-id='" . $lieferung->getLieferungsID() . "' 
                                data-lieferung-datum='" . $lieferung->getDatum() . "'
                                class='btn fa fa-info' 
                                data-toggle='modal' data-target='#modalZugeordneteLieferungArtikel'></button></td>
                          </tr>";
    }
}

echo $body;