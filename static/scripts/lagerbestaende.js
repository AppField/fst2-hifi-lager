(function () {

    // Artikel Tabelle laden.
    const loadData = () => {
        $('#lagerbestaendeliste').load('../php/lagerbestaende.php', () => {
            }
        );
    };

    loadData();


    const modal = $('#lagerstandModal');

    let articleModalInstanz = null;

    modal.on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget); // Button that triggered the modal
        const articleId = button.data('article-id'); // Extract info from data-* attributes
        const articleName = button.data('article-name');

        articleModalInstanz = new LagerbestandModal(articleId);

        const modal = $(this);
        modal.find('.modal-title').text('Artikel ' + articleName);
    });


    class LagerbestandModal {

        constructor(artikelid) {
            this.modal = modal;
            this.id = $('#artikelid');
            this.name = $('#artikelname');
            this.form = $('#modalForm');

            this.saveBtn = $('#saveBtn');

            this.saveBtn.unbind('click');
            this.saveBtn.on('click', (() => this.saveBestand()));

            $.ajax({
                url: '../php/lagerbestaende.php?artikelid=' + artikelid
            })
                .done((data) => {
                    const artikel = JSON.parse(data);
                    this.setValues(artikel);
                });
        }

        setValues(artikel) {
            this.id.val(artikel.artikelID);
            this.name.val(artikel.artikelname);
        }

        saveBestand() {
            const data = this.form.serializeArray();
            if (data.length === 0 || data.length === 1 || data[1].value === '') return;
            const artikel = {
                artikelid: this.id.val(),
                korrektur: data[0].value,
                anzahl: data[1].value
            };

            $.ajax({
                type: 'POST',
                url: '../php/lagerbestaendeSave.php',
                data: artikel,
                success: (result) => {
                    if (result == "true") {
                        modal.modal('hide');
                        console.log('saved successfully!');
                        loadData();
                        createNotifiction('Korrekturbuchung wurde erfolgreich gespeichert', true);
                    }
                    else {
                        modal.modal('hide');
                        console.error('save failed');
                        createNotifiction(result, false);
                    }
                },
                error: (error) => {
                    console.error('error', error);
                    createNotifiction('Korrekturbuchung konnte nicht gespeichert werden..', false);
                }
            })
        }
    }

}());

(function () {

    const modal = $('#modalLagerlogArtikelDetail');

    let modalInstanz = null;

    modal.on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget); // Button that triggered the modal
        const artikelid = button.data('artikel-id'); // Extract info from data-* attributes
        const artikelname = button.data('artikel-name');

        // modalInstanz = new ZugeordneteArtikelModal(lieferungId);

        const modal = $(this);
        modal.find('.modal-title').text('Artiekl ' + artikelid + ': ' + artikelname);
        modal.find('#gefilterterLagerlog').load('../php/lagerlogArtikelDetail.php?id=' + artikelid);
    });

}());

function mySearch() {
    var input, filter, table, tr, td, i, v;
    input = document.getElementById("myInput");
    filter = input.value.toLowerCase();
    table = document.getElementById("myTable");

    $( "table" ).removeClass( "table-striped" );

    var cnt = 0;

    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        td1 = tr[i].getElementsByTagName("td")[1];
        if (td || td1) {
            if (td.innerHTML.toLowerCase().indexOf(filter) > -1 || td1.innerHTML.toLowerCase().indexOf(filter) > -1) {

                tr[i].style.display = "";

                if(cnt % 2 != 0){
                    tr[i].style.background = "#EEF4F7";
                }else{
                    tr[i].style.background = "#E2E8EA";
                }
                cnt = cnt + 1;
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
