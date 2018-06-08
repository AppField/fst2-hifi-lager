<?php
/**
 * Created by PhpStorm.
 * User: johannes
 * Date: 07.06.18
 * Time: 13:27
 */
include '../models/Lagerlog.php';
include '../DB.php';

$db = New DB();
$lagerlog = $db->getLagerlog();
$logtable = "";
foreach ($lagerlog as $log) {
    $anzahl = 0;
    if ($log->getAenderung() == 'A' OR $log->getAenderung() == 'KA'){
        $anzahl = -$log->getAnzahl();
        $cell = "<td style='color: crimson'>".$anzahl."</td>";
    }else{
        $anzahl = $log->getAnzahl();
        $cell = "<td style='color: mediumseagreen'>".$anzahl."</td>";
    }

    $logtable .= "<tr align = \"center\">
                            <td>".$log->getAenderung()."</td>
                            <td>".$log->getLieferungsID()."</td>
                            <td>".$log->getArtikelID()."</td>
                            <td>".$log->getBezeichnung()."</td>"
                            .$cell.
                            "<td>".$log->getDatum()."</td>
                          </tr>";
}
echo $logtable;