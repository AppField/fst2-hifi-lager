<?php
$body = "";
include "models/Bestellung.php";
include "models/Artikel.php";
include "models/Lieferantenbestellung.php";
include "models/Lieferung.php";
include "models/Lieferantenlieferung.php";
include "DB.php";

if (isset($_GET["id"])) {
    $db = New DB();
    $lieferantenbestellungen = $db->getLieferantenbestellungWithID($_GET["id"]);
    $Lieferantenlieferungen = $db->getLieferantenlieferungenWithBestellungsID($_GET["id"]);
    $Lieferantenartiekl = $db->getLieferantenbestellungsArtikel($_GET["id"]);
    $body = "<div class=\"row justify-content-center features\" style=\"padding-top:40px;padding-bottom:100px;\">
                <div class=\"col-md-12\">
                    <form method=\"post\">
                        <div class=\"form-row\">
                            <div class=\"col-md-12\">
                                <h3>Allgemein<button class=\"btn btn-primary float-right m-auto\" type=\"button\" style=\"background-color:rgb(220,151,112);\" data-toggle=\"modal\" data-target=\"#exampleModalCenter\">Lieferung hinzufügen</button></h3>
                            </div>
                            <div class=\"col-md-6\">
                                <div class=\"form-group\"><label><strong>Bestellung - ID</strong><br></label><input class=\"form-control\" type=\"text\" value=\"" . $_GET["id"] . "\" disabled=\"\" readonly=\"\" name=\"firstname\"></div><label><strong>Lieferant</strong></label><input class=\"form-control\"
                                    type=\"text\" value=\"XYZ\" disabled=\"\" readonly=\"\" name=\"lastname\" style=\"margin-bottom:15px;\"><button class=\"btn btn-secondary m-auto\" type=\"button\" style=\"margin-bottom:0;background-color:rgb(220,151,112);\">Bestellschein anzeigen</button></div>
                        </div>
                        <hr>
                    </form>
                </div>
                <div class=\"col\"> <h3>Bestellte Artikel</h3>
              <div class=\"panel-body\">
                                <table class=\"table table-striped table-bordered table-list\">
                  <thead>
                    <tr align = \"center\">
                        <th class=\"hidden-xs\">Artikel - ID</th>
                        <th>Bezeichnung</th>
                        <th>Menge</th>
                    </tr> 
                  </thead>
                  <tbody>";

    foreach ($Lieferantenartiekl as $artikel){
        $body .= "<tr align = \"center\">
                            <td class=\"hidden-xs\">1</td>
                            <td>".$artikel->getArtikelname()."</td>
                            <td>".$db->getLieferantenbestellungsArtikelAnzahl($_GET["id"], $artikel->getArtikelID())."</td>
                          </tr>";
    }

   $body .= "</tbody>
                </table>
</div><hr> 
<h3>Lieferungen</h3>
              <div class=\"panel-body\">
                <table class=\"table table-striped table-bordered table-list\">
                  <thead>
                    <tr align = \"center\">
                        <th class=\"hidden-xs\">Lieferung - ID</th>
                        <th>Lieferschein</th>
                        <th>Datum</th>
                    </tr> 
                  </thead>
                  ";
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
    $body .= "</table>
            </div>
             </div>
            </div>
        </div>";
} else {
    $body = "error";
}
?>
