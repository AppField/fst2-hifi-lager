(function () {
    const lieferantInput = $('#lieferant');
    const artikelTable = $('#artikelTable');
    const lieferungenTable = $('#lieferungen');


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

    $('#bestellID').val(getQueryVariable('id'));

    $.ajax({
        url: '../php/lieferantenbestelldetails/getLieferant.php?id=' + getQueryVariable('id')
    }).done(data => {
        lieferantInput.val(data);
    });


    artikelTable.load('../php/lieferantenbestelldetails/artikelTable.php?id=' + getQueryVariable('id'), () => {

    });

    lieferungenTable.load('../php/lieferantenbestelldetails/getLieferungen.php?id=' + getQueryVariable('id'), () => {

    });

})();
