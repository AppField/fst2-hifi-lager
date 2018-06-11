<?php
/**
 * Created by PhpStorm.
 * User: johannes
 * Date: 08.06.18
 * Time: 11:20
 */
include "../../DB.php";
$body = "false";
$db = new DB();
var_dump($_REQUEST);
var_dump($_POST);
var_dump($_GET);
if (isset($_POST['bestellungsId'])) {
    $lid = $db->createLieferantenLieferung($_POST['bestellungsId']);
    if($lid == false){ return;}
    foreach ($_POST['artikel'] as $artikel) {
        ///TODO: Implement Insert into Artikeleingang w/ new LieferungsIDs
        if(!$db->createArtikeleingang($artikel['artikelId'],$artikel['artikelAnzahl'],$lid)){
            return;
        };
    }
    $body = $lid;
}
echo $body;