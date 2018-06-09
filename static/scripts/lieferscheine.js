(function () {

    $('#Kundendaten').load('../php/lieferscheindetails.php?kunde=true', () => {
    });

    $('#LieferscheinArtikelTable').load('../php/lieferscheindetails.php?kunde=false', () => {
    });



}());