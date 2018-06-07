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

            this.id = $('#artikelid');
            this.name = $('#artikelname');
            this.bestand = $('#bestand');

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
            this.bestand.val(artikel.lagerstand);
        }
    }

}());
