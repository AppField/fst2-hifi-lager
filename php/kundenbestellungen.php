<?php
/**
 * Created by PhpStorm.
 * User: johannes
 * Date: 07.06.18
 * Time: 12:54
 */
include "../models/Bestellung.php";
include "../models/Kundenbestellung.php";
include "../models/OffenerArtikel.php";
include "../DB.php";


$db = New DB();
$kundenbestellungen = $db->getKundenbestellungen();
$bestellungstable = "";
foreach ($kundenbestellungen as $bestellung) {

    if($bestellung->getStatus() == 'O'){
        $status = "Offen";

        $typ = $db->getKundenbestellungsLieferungsTyp($bestellung->getBestellungsID());

        if($typ == null or $typ == 0){
            $typ = "<i class=\"fa fa-times\"></i>";
        }else{
            $typ = "<i class=\"fa fa-check\"></i>";
        }

        $cnt = $db->getCntForBestell($bestellung->getBestellungsID());
        if($cnt == 0){
            $artikelVorhanden = "<i class=\"fa fa-check\" style='color: mediumseagreen'></i>";
        }else{
             if ($typ == 0) {
                 $artikelVorhanden = "<i class=\"fa fa-adjust\" style='color: orange'></i>";
             }else {
                 $artikelVorhanden = "<i class=\"fa fa-times\" style='color: crimson'></i>";
             }
        }

    }else{
        $status = "Abgeschlossen";
        $typ = "<i class=\"fa fa-minus\"></i>";
        $artikelVorhanden = "<i class=\"fa fa-minus\"></i>";
    }

    $bestellungstable .= "<tr align = \"center\">
                         <td class=\"hidden-xs filterDiv\">" . $bestellung->getBestellungsID() . "</td>
                            <td class=\"filterDiv\">" . $bestellung->getName() . "</td>
                            <td class=\"filterDiv " .$status."\">" . $status . "</td>
                            <td class=\"filterDiv\">" . $typ . "</td>
                            <td class=\"filterDiv\">" . $artikelVorhanden . "</td>
                             <td class=\"filterDiv\"align='center'>
                                <a class=\"\" href=\"kundenbestelldetails.html?id=" . $bestellung->getBestellungsID() . "&status=". $status ."\">
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

