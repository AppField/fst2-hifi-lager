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
$kundenbestellungen = $db->getKundenbestellungen();
foreach ($kundenbestellungen as $kb){
    echo $kb->getBestellungsID();
    echo $kb->getZugeordnet();
}

