(function () {

    const articleModal = $('#articleModal');

    let articleModalInstanz = null;

    articleModal.on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget); // Button that triggered the modal
        const articleId = button.data('article-id'); // Extract info from data-* attributes
        const articleName = button.data('article-name');

        articleModalInstanz = new ArtikelModal(articleId);

        const modal = $(this);
        modal.find('.modal-title').text('Artikel ' + articleName);
    });

    articleModal.on('hidden.bs.modal', (event) => {
        loadArticles();
    });


    // Artikel Tabelle laden.
    const loadArticles = () => {
        const artikelListe = $('#artikelListe');
        artikelListe.load('../php/artikel.php', () => {
        });
    };

    loadArticles();


    class ArtikelModal {

        constructor(artikelid) {

            this.id = $('#artikelid');
            this.name = $('#artikelname');
            this.bestand = $('#bestand');
            this.lagerort = $('#lagerort');
            this.saveBtn = $('#saveBtn');

            this.saveBtn.unbind('click');
            this.saveBtn.on('click', () => this.saveArtikel());

            $.ajax({
                url: '../php/artikel.php?artikelid=' + artikelid
            })
                .done((data) => {
                    const artikel = JSON.parse(data);
                    this.setValues(artikel);
                });
        }

        setValues(artikel) {
            this.id.val(artikel.artikelID);
            this.name.val(artikel.artikelname);
            this.bestand.val(artikel.lagerstand);
            this.lagerort.val(artikel.lagerort);
        }

        saveArtikel() {
            const artikel = {
                artikelid: this.id.val(),
                artikelname: this.name.val(),
                lagerort: this.lagerort.val()
            };

            $.ajax({
                method: "POST",
                url: '../php/artikelSave.php',
                data: artikel,
                success: (result) => {
                    if (result == "true") {
                        articleModal.modal('hide');
                        console.log('saved successfully!');
                        createNotifiction('Artikel wurde erfolgreich gespeichert', true);
                    }
                    else {
                        console.error('save failed');
                        createNotifiction(result.body, false);
                    }
                },
                error: (error) => {
                    console.error('error', error);
                }
            });
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
