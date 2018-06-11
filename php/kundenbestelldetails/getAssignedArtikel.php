<?php

include "../../models/Kunde.php";
include "../../models/Lieferschein.php";
include "../../DB.php";


if (isset($_GET['id'])) {

    $db = New DB();

    $assignedArtikel = $db->getKundenlieferungsArtikel($_GET['id']);
    $artikelTable = "";


    foreach ($assignedArtikel as $artikel) {

        $artikelTable .= '<tr align="center">
                            <td>' . $artikel->artikelID . '</td>
                            <td>' . $artikel->bezeichnung . '</td>
                            <td>' . $artikel->menge . '</td>
                          </tr>';
    }

    echo $artikelTable;


}


