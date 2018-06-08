<?php
/**
 * Created by PhpStorm.
 * User: johannes
 * Date: 08.06.18
 * Time: 11:20
 */
include "../DB.php";
$body = "true";
$db = new DB();
if(isset($_POST['artikelid'])){
    if(isset($_POST['artikelname'])){
        if(!$db->updateArtikelName($_POST['artikelid'], $_POST['artikelname'])){
            if($body == "true") $body = "";
            $body .= "Error updating Artikel Name";
        }
    }
    if(isset($_POST['lagerort'])){
        if(!$db->updateArtikelLagerort($_POST['artikelid'], $_POST['lagerort'])){
            if($body == "true") $body = "";
            $body .= "Error updating Artikel Lagerort";
        }
    }
}
echo $body;