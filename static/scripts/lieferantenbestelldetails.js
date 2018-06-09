(function () {
    const lieferantInput = $('#lieferant');
    const artikelTable = $('#artikelTable');
    const lieferungenTable = $('#lieferungen');


    function getQueryVariable(variable) {
        const query = window.location.search.substring(1);
        const vars = query.split("&");
        for (let i = 0; i < vars.length; i++) {
            const pair = vars[i].split("=");
            if (pair[0] === variable) {
                return pair[1];
            }
        }
        return (false);
    }

    $('#bestellID').val(getQueryVariable('id'));

    $.ajax({
        url: '../php/lieferantenbestelldetails/getLieferant.php?id=' + getQueryVariable('id')
    }).done(data => {
        lieferantInput.val(data);
    });


    artikelTable.load('../php/lieferantenbestelldetails/artikelTable.php?id=' + getQueryVariable('id'), () => {

    });

    lieferungenTable.load('../php/lieferantenbestelldetails/getLieferungen.php?id=' + getQueryVariable('id'), () => {

    });

    /* MODAL */
    const modal = $('#modal');

    let modalInstanz = null;

    modal.on('show.bs.modal', (event) => {
        const button = $(event.relatedTarget);

        modalInstanz = new LieferungHinzufuegenModal();

    });


    class LieferungHinzufuegenModal {

        constructor() {

            this.offeneArtikelContainer = $('#offeneArtikel');
            this.zugeordneteArtikelContainer = $('#zugeordneteArtikel');
            this.saveBtn = $('#saveBtn');

            this.saveBtn.on('click', () => this.saveLieferung());

            // $.ajax({
            //     url: '../php/artikel.php?artikelid=' + artikelid
            // })
            //     .done((data) => {
            //         const artikel = JSON.parse(data);
            //         this.setValues(artikel);
            //     });

            this.setupDragAndDrop();
        }

        setupDragAndDrop() {
            this.offeneArtikel = this.offeneArtikelContainer.find('.list-group-item');
            this.zugeordneteArtikel = this.zugeordneteArtikelContainer.find('.list-group-item');
            console.log(this.offeneArtikel);
            console.log(this.zugeordneteArtikel);

        }

        setValues(artikel) {
            // this.id.val(artikel.artikelID);
        }

        saveLieferung() {
            const lieferung = {
                // artikelid: this.id.val(),
                // artikelname: this.name.val(),
                // lagerort: this.lagerort.val()
            };

            // $.ajax({
            //     method: "POST",
            //     // url: '../php/artikelSave.php',
            //     data: artikel,
            //     success: (result) => {
            //         if (result) articleModal.modal('hide');
            //         else console.error('save failed');
            //     },
            //     error: (error) => {
            //         console.error('error', error);
            //     }
            // });
        }
    }

// BEGIN DRAG AND DROP

    // END DRAG AND DROP

})();
