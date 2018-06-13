(function () {

    // Artikel Tabelle laden.
    const loadData = () => {
        $('#lagerbestaendeliste').load('../php/lagerbestaende.php', () => {
        });
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


function mySearch() {
    var input, filter, table, tr, td, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
            if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
