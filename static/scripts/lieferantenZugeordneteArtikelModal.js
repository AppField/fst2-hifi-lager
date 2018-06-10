(function () {

    const modal = $('#modalZugeordneteLieferungArtikel');

    let modalInstanz = null;

    modal.on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget); // Button that triggered the modal
        const articleId = button.data('article-id'); // Extract info from data-* attributes
        const articleName = button.data('article-name');

        modalInstanz = new ZugeordneteArtikelModal(articleId);

        const modal = $(this);
        modal.find('.modal-title').text('Artikel ' + articleName);
    });

    modal.on('hidden.bs.modal', (event) => {
        loadBestaende();
    });


    class ZugeordneteArtikelModal {

        constructor(lieferungId) {
            this.modal = modal;
            this.id = $('#artikelid');
            this.name = $('#artikelname');
            this.form = $('#modalForm');

            this.saveBtn = $('#saveBtn');

            this.saveBtn.on('click', (() => this.saveBestand()));

            this.modal.find('#zugeordneteArtikelLiferungTable').load('../php/lieferantenLiferungZugeordneteArtikel.php?id=' + lieferungId);
        }
    }

}());