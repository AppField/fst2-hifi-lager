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
var_dump($_POST);
var_dump($_GET);
if (isset($_POST['bestellungsId'])) {
    echo $_POST['bestellungsId'];
    $lid = $db->createLieferantenLieferung($_POST['bestellungsId']);
    foreach ($_POST['artikel'] as $artikel) {
        ///TODO: Implement Insert into Artikeleingang w/ new LieferungsIDs
        echo $artikel['artikelId'];
        echo $artikel['artikelAnzahl'];
        $db->createArtikeleingang($artikel['artikelId'],$artikel['artikelAnzahl'],$lid);
    }
}
echo $body;