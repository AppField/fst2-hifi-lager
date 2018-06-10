<?php
/**
 * Created by PhpStorm.
 * User: Diana Öller
 * Date: 10.06.2018
 * Time: 12:08
 */

include "../../models/Kunde.php";
include "../../DB.php";
$db = New DB();
$kundendaten = "";

if(isset($_GET['id'])) {


    $kunde = $db->getKundenDetails($_GET['id]']);

    $kundendaten = "<p>Firma</br>" .
        $kunde->name . "</br>" .
        $kunde->strasse;
    if ($kunde->hausnummer != null) {
        $kundendaten .= $kunde->hausnummer;
    }
    $kundendaten .= "</br>" . $kunde->plz . " " . $kunde->ort . "</br></p>";
    $kundendaten .= "<p>Datum: " . date("d.m.Y");
    $kundendaten .= "</br> Kunden-NR: " . $kunde->kundenID . "</p>";


}
echo $kundendaten;
?>

