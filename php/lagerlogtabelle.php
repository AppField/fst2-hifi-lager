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
    $logtable .= "<tr align = \"center\">
                            <td class=\"hidden-xs\">2</td>
                            <td>".$log->getAenderung()."</td>
                            <td>".$log->getLieferungsID()."</td>
                            <td>".$log->getArtikelID()."</td>
                            <td>".$log->getBezeichnung()."</td>
                            <td>".$log->getAnzahl()."</td>
                            <td>".$log->getDatum()."</td>
                          </tr>";
}
echo $logtable;