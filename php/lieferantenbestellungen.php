<?php
/**
 * Created by PhpStorm.
 * User: johannes
 * Date: 07.06.18
 * Time: 12:52
 */


include "../models/Bestellung.php";
include "../models/Lieferantenbestellung.php";
include "../DB.php";
$db = New DB();
$lieferantenbestellungen = $db->getLieferantenbestellung();
$bestellungstable = "";

foreach ($lieferantenbestellungen as $bestellung) {

    if($bestellung->getAbgeschlossen() == 1){
        $status = "Abgeschlossen";
    }else{
        $status = "Offen";
    }

    $bestellungstable .= "<tr align = \"center\">
                            <td class=\"hidden-xs filterDiv\">" . $bestellung->getBestellungsID() . "</td>
                            <td class=\"filterDiv\">" . $bestellung->getName() . "</td>
                            <td class=\"filterDiv " .$status."\">" . $status . "</td>
                             <td class=\"filterDiv\"align='center'>
                                <a class=\"\" href=\"lieferantenbestelldetails.html?id=" . $bestellung->getBestellungsID() . "\">
                                    <button class=\"btn fa fa-edit\" ></button>
                                </a>
                            </td>
                          </tr>";
}
echo $bestellungstable;
?>