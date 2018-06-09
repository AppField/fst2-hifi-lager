<?php
/**
 * Created by PhpStorm.
 * User: johannes
 * Date: 07.06.18
 * Time: 13:52
 */
include "../models/Kunde.php";
include "../models/Lieferschein.php";
include "../DB.php";


if(isset($_GET['id'])) {

    $db = New DB();
    $kunde = $db->getKundenDetails($_GET['id]']);
    $artikel = $d->getKundenlieferungsArtikel($_GET['id']);


    $kundendaten = "<p>Firma</br>" .
        $kunde->name . "</br>" .
        $kunde->strasse;
    if ($kunde->hausnummer != null) {
        $kundendaten .= $kunde->hausnummer;
    }
    $kundendaten .= "</br>
                        $kunde->plz kunde->ort</br>
                      </p>";
    $kundendaten .= "<p>Datum: ";
    echo date("d.m.Y");

    echo $kundendaten;


    $artikeltable = "";

}


