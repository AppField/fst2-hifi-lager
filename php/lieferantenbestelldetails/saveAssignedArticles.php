<?php
/**
 * Created by PhpStorm.
 * User: johannes
 * Date: 08.06.18
 * Time: 11:20
 */
include "../../DB.php";
$body = "true";
$db = new DB();
var_dump($_POST);
var_dump($_GET);
if (isset($_POST['bestellungsId'])) {
    echo $_POST['bestellungsId'];
    foreach ($_POST['artikel'] as $artikel) {
        ///TODO: Implement Insert into Artikeleingang w/ new LieferungsIDs

    }
    var_dump($_POST['artikel']);
}
echo $body;