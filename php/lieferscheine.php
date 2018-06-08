<?php
/**
 * Created by PhpStorm.
 * User: johannes
 * Date: 07.06.18
 * Time: 13:52
 */
include "../models/Lieferung.php";
include "../models/Kundenlieferung.php";
include "../DB.php";
$db = New DB();
$kundenlieferungen = $db->getKundenlieferungen();
$bestellungstable = "";
foreach ($kundenlieferungen as $lieferung) {
    $bestellungstable .=     "<tr align = \"center\">
                            <td class=\"hidden-xs\">" . $lieferung->getBestellungsID() . "</td>
                            <td>" . $lieferung->getLieferungsID() . "</td>
                            <td align=\"center\">
                                <a class=\"\" href=\"lieferantenbestelldetails.html\">
                                    <button class=\"btn fa fa-print\" ></button>
                                </a>
                            </td>
                          </tr>";
}
echo $bestellungstable;