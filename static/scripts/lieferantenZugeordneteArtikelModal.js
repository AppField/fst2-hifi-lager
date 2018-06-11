(function () {

    const modal = $('#modalZugeordneteLieferungArtikel');

    let modalInstanz = null;

    modal.on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget); // Button that triggered the modal
        const lieferungId = button.data('lieferung-id'); // Extract info from data-* attributes
        const lieferungDatum = button.data('lieferung-datum');

        // modalInstanz = new ZugeordneteArtikelModal(lieferungId);

        const modal = $(this);
        modal.find('.modal-title').text('Lieferung ' + lieferungId + ' am ' + lieferungDatum);
        modal.find('#zugeordneteArtikelLieferungTable').load('../php/lieferantenbestelldetails/getAssignedArtikel.php?id=' + lieferungId);
    });

    //
    // class ZugeordneteArtikelModal {
    //
    //     constructor(lieferungId) {
    //         this.modal
    //
    //     }
    // }

}());