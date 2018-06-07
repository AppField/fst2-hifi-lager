<?php
/**
 * Created by PhpStorm.
 * User: johannes
 * Date: 07.06.18
 * Time: 18:44
 */
include "../../models/Bestellung.php";
include "../../models/Artikel.php";
include "../../models/Lieferantenbestellung.php";
include "../../models/Lieferung.php";
include "../../models/Lieferantenlieferung.php";
include "../../DB.php";
$db = new DB();
$body = "";
if (isset($_GET["id"])) {
    $Lieferantenlieferungen = $db->getLieferantenlieferungenWithBestellungsID($_GET["id"]);
    foreach ($Lieferantenlieferungen as $lieferung) {
        $body .= "<tbody>
                          <tr align = \"center\">
                            <td class=\"hidden-xs\">" . $lieferung->getLieferungsID() . "</td>
                            <td align=\"center\">
                              <a class=\"btn btn-default\">
                                  <button>
                                      <em class=\"fa fa-file-word-o\"></em>
                                  </button>
                              </a>
                            </td>
                            <td>" . $lieferung->getDatum() . "</td>
                          </tr>
                        </tbody>";
    }
}

echo $body;