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
    }

}());

