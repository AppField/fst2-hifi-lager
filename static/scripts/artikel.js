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

    // Artikel Tabelle laden.
    const loadData = () => {
        const artikelListe = $('#artikelListe');
        artikelListe.load('../php/artikel.php', () => {
        });
    };

    loadData();


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
                        loadData();
                        createNotifiction('Artikel wurde erfolgreich gespeichert', true);
                    }
                    else {
                        console.error('save failed');
                        loadData();
                        createNotifiction(result.body, false);
                    }
                },
                error: (error) => {
                    console.error('error', error);
                    loadData();
                    createNotifiction('Artikel konnte nicht gespeichert werden.', false);
                }
            });
        }
    }

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