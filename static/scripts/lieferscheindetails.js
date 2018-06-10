(function () {

    function getQueryVariable(variable) {
        const query = window.location.search.substring(1);
        const vars = query.split("&");
        for (let i = 0; i < vars.length; i++) {
            const pair = vars[i].split("=");
            if (pair[0] === variable) {
                return pair[1];
            }
        }
        return (false);
    }

    $('#Kundendaten').load('../php/lieferscheindetails/getKundendaten.php?id='+ getQueryVariable('id'), () => {
    });

    $('#LieferscheinArtikelTable').load('../php/lieferscheindetails/getArtikelTableLieferschein.php?id='+ getQueryVariable('id'), () => {
    });

}());