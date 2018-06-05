<?php
include "models/Bestellung.php";
include "models/Lieferantenbestellung.php";
include "DB.php";
$db = New DB();
$lieferantenbestellungen = $db->getLieferantenbestellung();
$bestellungstable = "";
foreach ($lieferantenbestellungen as $bestellung) {
    $bestellungstable .= "<tr align = \"center\">
                            <td class=\"hidden-xs\">" . $bestellung->getBestellungsID() . "</td>
                            <td>Offen</td>
                            <td align=\"center\">
                                <a class=\"\" href=\"bestelldetails.php?id=" . $bestellung->getBestellungsID() . "\">
                                    <button class=\"btn fa fa-edit\" ></button>
                                </a>
                            </td>
                          </tr>";
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
    <link rel="stylesheet" href="assets/css/Dark-Footer-1.css">
    <link rel="stylesheet" href="assets/css/Dark-Footer-2.css">
    <link rel="stylesheet" href="assets/css/Dark-Footer-3.css">
    <link rel="stylesheet" href="assets/css/Dark-Footer-4.css">
    <link rel="stylesheet" href="assets/css/Dark-Footer.css">
    <link rel="stylesheet" href="assets/css/Features-Boxed.css">
    <link rel="stylesheet" href="assets/css/Header-Dark.css">
    <link rel="stylesheet" href="assets/css/MUSA_panel-table.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
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
                <h2 class="text-center" style="font-size:58px;padding-top:30px;">Artikeleingang</h2>
            </div>
            <div class="row justify-content-center features" style="padding-top:40px;padding-bottom:100px;">
                <div class="col">
                    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css"
                          rel='stylesheet' type='text/css'>

                    <div class="container">
                        <div class="row">

                            <p></p>

                            <div class="col-md-12">

                                <div class="panel panel-default panel-table">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col col-xs-6">
                                                <h3 class="panel-title">Bestellliste</h3>
                                            </div>
                                            <div class="col col-xs-6 text-right">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <table class="table table-striped table-bordered table-list">
                                            <thead>
                                            <tr align="center">
                                                <th class="hidden-xs">Bestell - ID</th>
                                                <th>Status</th>
                                                <th><em class="fa fa-info-circle"></em></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            echo $bestellungstable;
                                            ?>
                                            </tbody>
                                        </table>

                                    </div>
                                    <div class="panel-footer">
                                        <div class="row">
                                            <div class="col col-xs-4">Page 1 of 5
                                            </div>
                                            <div class="col col-xs-8">
                                                <ul class="pagination hidden-xs pull-right">
                                                    <li><a href="#">1</a></li>
                                                    <li><a href="#">2</a></li>
                                                    <li><a href="#">3</a></li>
                                                    <li><a href="#">4</a></li>
                                                    <li><a href="#">5</a></li>
                                                </ul>
                                                <ul class="pagination visible-xs pull-right">
                                                    <li><a href="#">«</a></li>
                                                    <li><a href="#">»</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="footer-dark">
    <footer>
        <div class="container">
            <p class="copyright">HiFiSound © 2018</p>
        </div>
    </footer>
</div>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/Profile-Edit-Form.js"></script>
</body>

</html>