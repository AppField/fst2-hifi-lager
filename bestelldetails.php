<?php
$body = "";
include "models/Bestellung.php";
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
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lagersystem</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bitter:400,700">
    <link rel="stylesheet" href="assets/css/Contact-Form-Clean.css">
    <link rel="stylesheet" href="assets/css/Dark-Footer-1.css">
    <link rel="stylesheet" href="assets/css/Dark-Footer-2.css">
    <link rel="stylesheet" href="assets/css/Dark-Footer-3.css">
    <link rel="stylesheet" href="assets/css/Dark-Footer-4.css">
    <link rel="stylesheet" href="assets/css/Dark-Footer.css">
    <link rel="stylesheet" href="assets/css/Data-Summary-Panel---3-Column-Overview--Mobile-Responsive.css">
    <link rel="stylesheet" href="assets/css/Features-Boxed.css">
    <link rel="stylesheet" href="assets/css/Footer-Dark.css">
    <link rel="stylesheet" href="assets/css/Formulario-Farmacia.css">
    <link rel="stylesheet" href="assets/css/FPE-Gentella-form-elements-1.css">
    <link rel="stylesheet" href="assets/css/FPE-Gentella-form-elements.css">
    <link rel="stylesheet" href="assets/css/Header-Dark.css">
    <link rel="stylesheet" href="assets/css/MUSA_panel-table-1.css">
    <link rel="stylesheet" href="assets/css/MUSA_panel-table.css">
    <link rel="stylesheet" href="assets/css/Profile-Edit-Form-1.css">
    <link rel="stylesheet" href="assets/css/Profile-Edit-Form.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body style="background-color:#eef4f7;">
<main>
    <div class="features-boxed">
        <div class="container">
            <nav class="navbar navbar-light navbar-expand-md" style="margin-right:0px;">
                <div class="container-fluid"><a class="navbar-brand" href="index.html"
                                                style="background-image:url(&quot;assets/img/icon_2.png&quot;);width:200px;background-repeat:no-repeat;background-size:cover;height:83px;margin-right:20px;"></a>
                    <button class="navbar-toggler" data-toggle="collapse"
                            data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span
                                class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse flex-row-reverse" id="navcol-1" style="padding-right:0px;">
                        <ul class="nav navbar-nav" style="margin-right:0;padding-right:0px;padding-left:30px;">
                            <li class="nav-item" role="presentation"><a class="nav-link" href="index.html">Home</a></li>
                            <li class="nav-item" role="presentation"><a class="nav-link" href="artikel.php">Artikel</a>
                            </li>
                            <li class="nav-item" role="presentation"><a class="nav-link active"
                                                                        href="artikeleingang.php">Artikeleingang</a>
                            </li>
                            <li class="nav-item" role="presentation"><a class="nav-link" href="artikelausgang.php">Artikelausgang</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="intro">
                <h2 class="text-center" style="font-size:58px;padding-top:30px;">Bestelldetails</h2>
            </div>
            <?php
            echo $body;
            ?>
            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Lieferung hinzufügen</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Eingehende Artikel:</label>
                                    <div class="form-row">
                                        <div class="col">
                                            <input type="text" class="form-control" placeholder="Artikel Bezeichnung">
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control" placeholder="Menge">
                                        </div>
                                        <div class="col">
                                            <button class
                                            "btn btn-secondary">Reihe hinzufügen</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="message-text" class="col-form-label">Lieferschein:</label>
                                    <input type="file" class="form-control" id="lieferschein">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success">Hinzufügen</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</main>
<div class="footer-dark">
    <footer class="m-auto" style="width:1000px;">
        <div class="container">
            <p class="copyright">HiFiSound© 2018</p>
        </div>
    </footer>
</div>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/Profile-Edit-Form.js"></script>
</body>

</html>