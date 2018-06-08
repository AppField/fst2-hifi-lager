<?php
/**
 * Created by PhpStorm.
 * User: johannes
 * Date: 08.06.18
 * Time: 11:20
 */
include "../DB.php";
$body = "";
$db = new DB();
if(isset($_POST['artikelid'])){
    if(isset($_POST['artikelname'])){
        if(!$db->updateArtikelName($_POST['artikelid'], $_POST['artikelname'])){
            $body .= "Error updating Artikel Name";
        }
    }
    if(isset($_POST['lagerort'])){
        if(!$db->updateArtikelLagerort($_POST['artikelid'], $_POST['lagerort'])){
            $body .= "Error updating Artikel Lagerort";
        }
    }
}
echo $body;