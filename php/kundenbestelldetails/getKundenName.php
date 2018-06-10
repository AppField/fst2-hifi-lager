<?php
/**
 * Created by PhpStorm.
 * User: johannes
 * Date: 07.06.18
 * Time: 18:34
 */
include "../../models/Bestellung.php";
include "../../models/Artikel.php";
include "../../models/Kundenbestellung.php";
include "../../models/Lieferung.php";
include "../../models/Kundenlieferung.php";
include "../../DB.php";
$db = new DB();
if (isset($_GET["id"])) {
    $db = New DB();
    $bestellung = $db->getKundenbestellungenWithID($_GET["id"]);
    echo $bestellung->getName();
}else echo "Fail";
