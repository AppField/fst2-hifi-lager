<?php
/**
 * Created by PhpStorm.
 * User: johannes
 * Date: 07.06.18
 * Time: 18:44
 */
include "../../models/Bestellung.php";
include "../../models/Artikel.php";
include "../../models/Lieferantenbestellung.php";
include "../../models/Lieferung.php";
include "../../models/Lieferantenlieferung.php";
include "../../models/OffenerArtikel.php";
include "../../DB.php";
$db = new DB();
$template = "";
if (isset($_GET["id"])) {
    $Lieferantenartiekl = $db->getOffeneArtikelKundenbestellung($_GET["id"]);
    foreach ($Lieferantenartiekl as $artikel){

        $id = $artikel->getID();
        $bestellt = $artikel->getAnzahl();
        $lagerstand = $db->getOffenerArtikelBestand($id);

        if($bestellt < $lagerstand){
            $template .= '<li class="list-group-item d-flex justify-content-between align-items-center"
                draggable="true" data-artikel-id="'.$artikel->getID().'" data-artikel-name="'.$artikel->getBezeichnung().'"
                data-artikel-anzahl="'.$artikel->getAnzahl().'">
                    '.$artikel->getBezeichnung().'
                <span class="anzahl-badge badge badge-primary badge-pill">'.$artikel->getAnzahl().'</span>
            </li>';
        }else{
            $template .= '<li class="list-group-item d-flex justify-content-between align-items-center"
                draggable="true" data-artikel-id="'.$artikel->getID().'" data-artikel-name="'.$artikel->getBezeichnung().'"
                data-artikel-anzahl="'.$lagerstand.'">
                    '.$artikel->getBezeichnung().'
                <span class="anzahl-badge badge badge-primary badge-pill">'.$lagerstand.'</span>
            </li>';
            $template .= '<li class="list-group-item d-flex justify-content-between align-items-center"
                draggable="false" data-artikel-id="'.$artikel->getID().'-n" data-artikel-name="'.$artikel->getBezeichnung().'"
                data-artikel-anzahl="'.($artikel->getAnzahl() - $lagerstand).'" style="color:crimson;">
                    '.$artikel->getBezeichnung().'
                <span class="anzahl-badge badge badge-primary badge-pill" style="background-color:crimson;">'.($artikel->getAnzahl() - $lagerstand).'</span>
            </li>';
        }
//        $template .= '<li class="list-group-item d-flex justify-content-between align-items-center"
//                draggable="true" data-artikel-id="'.$artikel->getID().'" data-artikel-name="'.$artikel->getBezeichnung().'"
//                data-artikel-anzahl="'.$artikel->getAnzahl().'">
//                    '.$artikel->getBezeichnung().'
//                <span class="anzahl-badge badge badge-primary badge-pill">'.$artikel->getAnzahl().'</span>
//            </li>';
    }
}




echo $template;