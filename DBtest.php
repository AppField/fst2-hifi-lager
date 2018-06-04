<?php

include 'DB.php';
/**
 * Created by PhpStorm.
 * User: Diana Öller
 * Date: 02.06.2018
 * Time: 09:49
 */

$db = new DB();
$db->doConnect();
echo 'Kundenbestellungen </br>';
$kundenbestellungen = $db->getKundenbestellungen();
var_dump($kundenbestellungen);
echo 'Lieferantenbestelllungen </br>';
$lieferantenbestellungen = $db->getLieferantenbestellung();
var_dump($lieferantenbestellungen);