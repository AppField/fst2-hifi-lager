<?php
/**
 * Created by PhpStorm.
 * User: Diana Öller
 * Date: 10.06.2018
 * Time: 12:08
 */
include "../models/Kunde.php";
include "../models/Lieferschein.php";
include "../DB.php";


if(isset($_GET['id'])) {

    $db = New DB();
    $kunde = $db->getKundenDetails($_GET['id]']);
    $lieferungen = $d->getKundenlieferungsArtikel($_GET['id']);
    $artikeltable = "";


    $kundendaten = "<p>Firma</br>" .
        $kunde->name . "</br>" .
        $kunde->strasse;
    if ($kunde->hausnummer != null) {
        $kundendaten .= $kunde->hausnummer;
    }
    $kundendaten .= "</br>".$kunde->plz." ".kunde->ort."</br></p>";
    $kundendaten .= "<p>Datum: ".date("d.m.Y");
    $kundendaten .= "</br> Kunden-NR: ".$kunde->kundenID."</p>";

    $count = 1;
    foreach ($lieferungen as $artikel) {

        $artikeltable .=     "<tr align = \"center\">
                            <td class=\"hidden-xs\">" . $count. ".</td>
                            <td>" . $artikel->artikelID . "</td>
                            <td>" . $artikel->bezeichnung . "</td>
                            <td>" . $artikel->menge. "</td>
                          </tr>";
        $count ++;
    }

    echo $bestellungstable;


}


