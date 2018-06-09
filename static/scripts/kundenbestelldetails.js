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
            this.OFFENEARTIKELID = 'offeneArtikel';
            this.ZUGEORDNETEARTIKELID = 'zugeordneteArtikel';

            // DROP ZONES
            this.offeneArtikelContainer = $('#offeneArtikel');
            this.zugeordneteArtikelContainer = $('#zugeordneteArtikel');
            this.lastEnter = null;

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

        setValues(artikel) {
            // this.id.val(artikel.artikelID);
        }

        setupDragAndDrop() {
            this.offeneArtikel = this.offeneArtikelContainer.find('.list-group-item');
            this.zugeordneteArtikel = this.zugeordneteArtikelContainer.find('.list-group-item');
            console.log(this.offeneArtikel);
            console.log(this.zugeordneteArtikel);


            this.offeneArtikel.map(idx => {
                this.setupDragAndDropEvents(this.offeneArtikel[idx]);
            });
            // this.setupDragAndDropEvents(this.zugeordneteArtikelContainer);
            this.zugeordneteArtikel.map(idx => {
                this.setupDragAndDropEvents(this.zugeordneteArtikel[idx]);
            });

            this.offeneArtikelContainer.on('dragover', this.dragover);
            this.offeneArtikelContainer.on('dragleave', this.dragleave);
            this.offeneArtikelContainer.on('dragenter', this.dragenter);
            this.offeneArtikelContainer.on('drop', (event) => this.drop(event));


            this.zugeordneteArtikelContainer.on('dragover', this.dragover);
            this.zugeordneteArtikelContainer.on('dragleave', this.dragleave);
            this.zugeordneteArtikelContainer.on('dragenter', this.dragenter);
            this.zugeordneteArtikelContainer.on('drop', (event) => this.drop(event));
        }

        setupDragAndDropEvents(artikelItem) {
            $(artikelItem).on('dragstart', this.dragstart);
            $(artikelItem).on('dragend', this.dragend);
        }

        dragstart(event) {
            $(this).addClass('drag-held');

            const target = $(event.target);
            const artikelId = target.data('artikel-id');
            const artikelName = target.data('artikel-name');
            const artikelAnzahl = target.data('artikel-anzahl');
            event.originalEvent.dataTransfer.setData("text/html", artikelId + '|' + artikelName + "|" + artikelAnzahl + '|' + event.target.parentNode.id);
            event.originalEvent.dataTransfer.dropEffect = 'move'

        }


        dragenter(event) {
            event.preventDefault();
            console.log('DRAG ENTER!');
            this.lastEnter = event;
            $(this).addClass('drag-over');
        }

        dragover(event) {
            event.preventDefault();
        }

        dragleave(event) {
            event.preventDefault();
            console.log('DRAG LEAVE');
            if (this.lastEnter.target === event.target) {
                $(this).removeClass('drag-over');
            }
        }


        drop(event) {
            const data = event.originalEvent.dataTransfer.getData('text/html');
            const dropData = data.split('|');
            const artikelId = dropData[0];
            const artikelName = dropData[1];
            const artikelAnzahl = dropData[2];

            console.log(artikelId, artikelName, artikelAnzahl);
            const prevElem = dropData[3];

            let newItem = null;
            const dropZone = $(event.target.parentElement);
            if (prevElem === this.OFFENEARTIKELID) {
                if (dropZone.attr('id') === this.ZUGEORDNETEARTIKELID) {

                    newItem = this.createAssignedItem(artikelId, artikelName, artikelAnzahl);
                    dropZone.append(newItem);

                }
            } else if (prevElem === this.ZUGEORDNETEARTIKELID) {
                if (dropZone.attr('id') === this.OFFENEARTIKELID) {

                    newItem = this.createOpenItem(artikelId, artikelName, artikelAnzahl);
                    dropZone.append(newItem);

                }
            }

            $(this).removeClass('drag-held');
            $(this.parentElement).removeClass('drag-over');
            event.preventDefault();
        }

        dragend(event) {
            $(this).removeClass('drag-held');
            $(this.parentElement).removeClass('drag-over');
        }

        createOpenItem(artikelId, artikelName, artikelAnzahl) {
            return $(`<li class="list-group-item d-flex justify-content-between align-items-center"
                        draggable="true" data-artikel-id="${artikelId}" data-artikel-name="${artikelName}"
                        data-artikel-anzahl="${artikelAnzahl}">
                        ${artikelName}
                        <span class="badge badge-primary badge-pill">${artikelAnzahl}</span>
                    </li>         
                    `);
        }

        createAssignedItem(artikelId, artikelName, artikelAnzahl) {
            return $(`<li class="list-group-item d-flex justify-content-between align-items-center"
                        draggable="true" data-artikel-id="${artikelId}" data-artikel-name="${artikelName}"
                        data-artikel-anzahl="${artikelAnzahl}">
                        ${artikelName}
                        <span class="badge badge-primary badge-pill">${artikelAnzahl}</span>
                    </li>         
                    `);
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
