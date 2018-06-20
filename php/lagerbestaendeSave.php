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
$body = "false";
$db = new DB();
if(isset($_POST['artikelid'])){
    if(isset($_POST['korrektur'])) {
        if (isset($_POST['anzahl'])) {
//            if (!$db->createlagerlog((string)$_POST['artikelid'], (string)$_POST['anzahl'], (string)$_POST['korrektur'])) {
//                echo "error beim artikeleingang erstellen";
//                return;
//            }

            $do = $db->createlagerlog((string)$_POST['artikelid'], (string)$_POST['anzahl'], (string)$_POST['korrektur']);

            if($do == false){ echo "error beim erstellen der Lieferung"; return;}
            $body = "true";
        }
    }
}
echo $body;