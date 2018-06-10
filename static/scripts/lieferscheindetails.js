(function () {


    $('#Kundendaten').load('../php/lieferscheindetails/getKundendaten.php', () => {
    });

    $('#LieferscheinArtikelTable').load('../php/lieferscheindetails/getArtikelTableLieferschein.php', () => {
    });

}());