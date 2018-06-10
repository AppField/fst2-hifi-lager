<?php
/**
 * Created by PhpStorm.
 * User: Diana Öller
 * Date: 10.06.2018
 * Time: 12:10
 */


include "../../models/Lieferschein.php";
include "../../DB.php";

$db = New DB();
$artikeltable = "";
if(isset($_GET['id'])) {
    $lieferungen = $db->getKundenlieferungsArtikel($_GET['id']);


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



}
echo $artikeltable;