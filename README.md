# fst2-hifi-lager

[![Build Status](https://travis-ci.org/TheAppField/fst2-hifi-lager.svg?branch=master)](https://travis-ci.org/TheAppField/fst2-hifi-lager)

![alt text](https://github.com/TheAppField/fst2-hifi-lager/raw/master/static/assets/img//icon_2.png)

Implementierung der Fallstudie 2

#### TODO:
- bei artikel.hmtml lagerort oder bezeichnung anpassen function (über artikel id)
    - echo false bzw true;
- bei lagerstand.html lagerstand anpassen funciton (über artikel id)
    - insert ins lagerlog
    - echo false bzw true;
- bestelldetails lieferant ????
- bestelldetails insert: lieferantenlieferung maxid +1, curdate() , bestellung
     - insert post JSON artikel + menge
- Spezifikationen anpassen
- .class.php refactoring
- artikel.php änderungs funktion
- Diana: Icons in der Titelleiste einfuefen - DONE


### Bestelldetails Lieferungen
Drag and Drop wurde implementiert zum Zuordnen von Artikeln zu  Lieferungen.
Frontend sendet folgendes zum Backend:

- Datei: *saveAssignedArticles.php*
- Kundenbestelldetails anpassen (derzeit wird der Code der lieferantenbestelldetails PHP files verwendet)
- LieferantID wird bei der Bestellung derzeit nicht mitgegeben
JSON Format:
```json
{
  "bestellungsId": "1",
  "lieferantID": "HappyLieferung Spediteur",
  "artikel": [
    {
      "artikelId": 1,
      "artikelName": "Kopfhoerer",
      "artikelAnzahl": 10
    },
    {
      "artikelId": 2,
      "artikelName": "Lautsprecher",
      "artikelAnzahl": 3
    }
  ]
}
```  
 
 Template fuer offene Artikel in *Liferung hinzufuegen* Modal:
 ```php
// TEMPLATE FUER OFFENEN ARTIKEL

$template = '<li class="list-group-item d-flex justify-content-between align-items-center"
    draggable="true" data-artikel-id="1" data-artikel-name="Kopfhoerer"
    data-artikel-anzahl="10">
        Kopfhoerer
    <span class="anzahl-badge badge badge-primary badge-pill">10</span>
</li>';
```
