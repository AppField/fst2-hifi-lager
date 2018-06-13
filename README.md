# fst2-hifi-lager

[![Build Status](https://travis-ci.org/TheAppField/fst2-hifi-lager.svg?branch=master)](https://travis-ci.org/TheAppField/fst2-hifi-lager)

![alt text](https://github.com/TheAppField/fst2-hifi-lager/raw/master/static/assets/img//icon_2.png)

Implementierung der Fallstudie 2

#### TODO:
- bestelldetails insert: lieferantenlieferung maxid +1, curdate() , bestellung
     - insert post JSON artikel + menge
     - Bestellmenge vor dem insert muss überprüft werden
- Spezifikationen anpassen
- .class.php refactoring
- Db funktion: Lieferung löschen
- Kundenbestelldetails neue Spalte: 
    - Artikel Verfuegbar JA/NEIN (Icon)
- Boolean Feld fuer Gesamtlieferung hinzufuegen    
- Lieferung hinzufuegen, offene Artikel:
    - Nur Artikel laden, die verfuegbar sind oder die verfuegbaren Artikel.


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

```
curl --user fst2:pass4fst2 --data " {
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
                                    }" 
                                    http://wi-project.technikum-wien.at/s18/s18-bvz2-fst-32/static/artikeleingang.html
                              
```


### Besprechung 11.06.2018
- Kundenbestelldetails neue Spalte: 
    - Artikel Verfuegbar JA/NEIN (Icon)
- Boolean Feld fuer Gesamtlieferung hinzufuegen    
- Lieferung hinzufuegen, offene Artikel:
    - Nur Artikel laden, die verfuegbar sind oder die verfuegbaren Artikel.
- Lieferung nur hinzufügen können solange status "offen" ( Status mit uebergeben)
