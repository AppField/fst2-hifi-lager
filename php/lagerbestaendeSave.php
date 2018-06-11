<?php
/**
 * Created by PhpStorm.
 * User: astan
 * Date: 11.06.2018
 * Time: 13:23
 */

//{
//    "artikelid": "1",
//    "korrektur": "ke oder ka",
//    "anzahl": "12"
//}

include "../DB.php";
$body = "true";
$db = new DB();
if(isset($_POST['artikelid'])){
    if(isset($_POST['korrektur'])) {
        if (isset($_POST['anzahl'])) {
            if (!$db->createlagerlog((string)$_POST['artikelid'], (string)$_POST['anzahl'], (string)$_POST['korrektur'])) {
                if ($body == "true") $body = "";
                $body .= "Error updating Bestand";
                $body .= "<br>";
                $body .= "ID: " .$_POST['artikelid'];
                $body .= "<br>";
                $body .= "Korrektur: " .$_POST['korrektur'];
                $body .= "<br>";
                $body .= "Anzahl: " .$_POST['anzahl'];
            }
        }
    }
}
echo $body;