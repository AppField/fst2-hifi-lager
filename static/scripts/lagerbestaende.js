(function () {

    // Artikel Tabelle laden.
    const loadBestaende = () => {
        $('#lagerbestaendeliste').load('../php/lagerbestaende.php', () => {
        });
    };

    loadBestaende();


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

    modal.on('hidden.bs.modal', (event) => {
        loadBestaende();
    });


    class LagerbestandModal {

        constructor(artikelid) {
            this.modal = modal;
            this.id = $('#artikelid');
            this.name = $('#artikelname');
            this.form = $('#modalForm');

            this.saveBtn = $('#saveBtn');

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
                    if (result) modal.modal('hide');
                    else console.error('save failed');
                },
                error: (error) => {
                    console.error('error', error);
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
