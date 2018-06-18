<?php
/**
 * Created by PhpStorm.
 * User: astan
 * Date: 18.06.2018
 * Time: 09:39
 */

include '../models/Lagerlog.php';
include '../DB.php';

$db = New DB();
$id = $_GET['id'];
$lagerlog = $db->getDetailedLagerlog($id);
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
    if($log->getLieferungsID() == 999){
        $lieferID = "<td>Korrektur</td>";
    }else{
        $lieferID = "<td>".$log->getLieferungsID()."</td>";
    }

    $alterbestand = $log->getAlterBestand();
    $neuerbestand = $log->getNeuerBestand();

    $logtable .= "<tr align = \"center\">
                            <td>".$log->getAenderung()."</td>
                            .$lieferID
                            $cell.
                            <td>".$alterbestand."</td>
                            <td>".$neuerbestand."</td>
                            <td>".$log->getDatum()."</td>
                          </tr>";
}
echo $logtable;