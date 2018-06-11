<?php
/**
 * Created by PhpStorm.
 * User: johannes
 * Date: 07.06.18
 * Time: 12:54
 */
include "../models/Bestellung.php";
include "../models/Kundenbestellung.php";
include "../DB.php";


$db = New DB();
$kundenbestellungen = $db->getKundenbestellungen();
$bestellungstable = "";
foreach ($kundenbestellungen as $bestellung) {

    if($bestellung->getStatus() == 'O'){
        $status = "Offen";
    }else{
        $status = "Abgeschlossen";
    }

    $bestellungstable .= "<tr align = \"center\">
                         <td class=\"hidden-xs filterDiv\">" . $bestellung->getBestellungsID() . "</td>
                            <td class=\"filterDiv\">" . $bestellung->getName() . "</td>
                            <td class=\"filterDiv " .$status."\">" . $status . "</td>
                             <td class=\"filterDiv\"align='center'>
                                <a class=\"\" href=\"kundenbestelldetails.html?id=" . $bestellung->getBestellungsID() . "\">
                                    <button class=\"btn fa fa-edit\" ></button>
                                </a>
                            </td>
                      </tr>";
}
echo $bestellungstable;

//<td class=\"hidden-xs\">" . $bestellung->getBestellungsID() . "</td>
//                        <td>" . $bestellung->getName() . "</td>
//                        <td>Offen</td>
//                        <td align=\"center\">
//                            <a class=\"\" href=\"kundenbestelldetails.html?id=" . $bestellung->getBestellungsID() . "\">
//                                <button class=\"btn fa fa-edit\" ></button>
//                            </a>
//                        </td>

