<?php
/**
 * Created by PhpStorm.
 * User: johannes
 * Date: 07.06.18
 * Time: 18:34
 */
include "models/Bestellung.php";
include "models/Lieferantenbestellung.php";
include "DB.php";

if (isset($_GET["id"])) {
    $db = New DB();
    $bestellung = $db->getLieferantenbestellungWithID($_GET["id"]);
    echo $bestellung->getName();
}
