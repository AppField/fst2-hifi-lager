<?php
/**
 * Created by PhpStorm.
 * User: johannes
 * Date: 07.06.18
 * Time: 13:36
 */
include "../models/Artikel.php";
include "../DB.php";
$db = New DB();

if (!empty($_GET['artikelid'])) {
    $artikelId = $_GET['artikelid'];


    $artikel = $db->getArtikelById($artikelId);

    echo json_encode($artikel);

} else {
//    GET ALL
    $artikelarray = $db->getArtikel();
    $artikelTable = "";
    foreach ($artikelarray as $artikel) {
        $artikelTable .= "<tr align = \"center\">
                            <td class=\"hidden-xs\">" . $artikel->getArtikelID() . "</td>
                            <td>" . $artikel->getArtikelname() . "</td>
                            <td>" . $artikel->getLagerstand() . "</td>
                            <td align=\"center\">
                              <a class=\"btn btn-default\" 
                              data-toggle=\"modal\" 
                              data-target=\"#lagerstandModal\" 
                              data-article-id=" . $artikel->getArtikelID() . "
                              data-article-name='" . $artikel->getArtikelname() . "'><em class=\"fa fa-pencil\"></em></a>
                            </td>
                          </tr>";
    }
    echo $artikelTable;
}
?>