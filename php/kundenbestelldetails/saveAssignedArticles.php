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
if (isset($_POST['bestellungsId'])) {
    $lid = $db->createKundenLieferung($_POST['bestellungsId']);
    if ($lid == false) {
        echo "error beim erstellen der Lieferung";
        $db->deleteKundenLieferung($_POST['bestellungsId']);
        return;
    }
    foreach ($_POST['artikel'] as $artikel) {
        if (!$db->createArtikelausgang($artikel['artikelId'], $artikel['artikelAnzahl'], $lid)) {
            echo "error beim erstellen des Artikelausgang";
            $db->deleteKundenLieferung($_POST['bestellungsId']);
            return;
        };
    }
    $body = "true";
}
echo $body;