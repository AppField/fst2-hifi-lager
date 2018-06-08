function getQueryVariable(variable)
    {
        var query = window.location.search.substring(1);
        var vars = query.split("&");
        for (var i=0;i<vars.length;i++) {
            var pair = vars[i].split("=");
            if(pair[0] == variable){return pair[1];}
        }
        return(false);
    }

    $('#bestellID').val(getQueryVariable('id'));
    $('#lieferant').valueOf().load('../php/lieferantenbestelldetails/getLieferant.php?id='+getQueryVariable('id'), () => {
});
    $('#artikelTable').load('../php/lieferantenbestelldetails/artikelTable.php?id='+getQueryVariable('id'), () => {
});
    $('#lieferungen').load('../php/lieferantenbestelldetails/getLieferungen.php?id='+getQueryVariable('id'), () => {
});