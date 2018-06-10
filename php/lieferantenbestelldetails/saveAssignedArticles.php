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
if (isset($_POST['bestellungsId'])) {

    foreach ($_POST['artikel'] as $artikel) {
        ///TODO: Implement Insert into Artikeleingang w/ new LieferungsID
    }

}
echo $body;