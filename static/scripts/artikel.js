(function () {

    $('#artikelListe').load('../php/artikel.php', () => {
    });

    $('#articleModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget); // Button that triggered the modal
        const articleId = button.data('article-id'); // Extract info from data-* attributes
        const articleName = button.data('article-name');
        console.log('articleName:', articleName);
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

        const modal = $(this);
        modal.find('.modal-title').text('Artikel ' + articleName);
    })

}());

