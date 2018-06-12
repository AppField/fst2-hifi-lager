<?php

include "../../models/Kunde.php";
include "../../models/Lieferschein.php";
include "../../DB.php";


if (isset($_GET['id'])) {

    $db = New DB();

    $assignedArtikel = $db->getLieferantenlieferungsArtikel($_GET['id']);
    $artikelTable = "";


    foreach ($assignedArtikel as $artikel) {

        $artikelTable .= '<tr align="center">
                            <td>' . $artikel->getArtikelID() . '</td>
                            <td>' . $artikel->getBezeichnung(). '</td>
                            <td>' . $artikel->getMenge() . '</td>
                          </tr>';
    }

    echo $artikelTable;


}


