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
            this.lastEnter = event;
            $(this).addClass('drag-over');
        }

        dragover(event) {
            event.preventDefault();
        }

        dragleave(event) {
            event.preventDefault();
            if (this.lastEnter.target === event.target) {
                $(this).removeClass('drag-over');
            }
        }


        drop(event) {
            const data = event.originalEvent.dataTransfer.getData('text/html');
            const dropData = data.split('|');
            const artikel = {
                artikelId: dropData[0],
                artikelName: dropData[1],
                artikelAnzahl: dropData[2],
            };

            const prevElem = dropData[3];

            let newItem = null;
            const dropZone = event.target.tagName === "UL" ? $(event.target) : $(event.target.parentElement);

            if (prevElem === this.OFFENEARTIKELID) {

                this.handleDropAssigned(dropZone, artikel);

            } else if (prevElem === this.ZUGEORDNETEARTIKELID) {

                this.handleDropOpen(dropZone, artikel);

            }

            $(this).removeClass('drag-held');
            dropZone.removeClass('drag-over');
            event.preventDefault();
        }

        dragend(event) {
            $(this).removeClass('drag-held');
            $(this.parentElement).removeClass('drag-over');
        }


        handleDropOpen(dropZone, artikel) {
            if (dropZone.attr('id') === this.OFFENEARTIKELID) {

                const newItem = this.createOpenItem(artikel.artikelId, artikel.artikelName, artikel.artikelAnzahl);
                dropZone.append(newItem);

            }
        }

        handleDropAssigned(dropZone, artikel) {
            if (dropZone.attr('id') === this.ZUGEORDNETEARTIKELID) {

                if (!this.isAssigned(artikel.artikelId)) {
                    const newItem = this.createAssignedItem(artikel.artikelId, artikel.artikelName, artikel.artikelAnzahl);
                    $('.dnd-info').hide();
                    dropZone.append(newItem);
                    this.updateOpenAmount(artikel.artikelId, 0);
                }

            }
        }

        /*
         * Used to prevent adding the same article again
         */
        isAssigned(artikelId) {
            return this.getAssignedArticle(artikelId).length !== 0;
        }

        getOpenArticle(artikelId) {
            return $(`#offeneArtikel [data-artikel-id=${artikelId}]`);
        }

        getAssignedArticle(artikelId) {
            return $(`#zugeordneteArtikel [data-artikel-id=${artikelId}]`);
        }

        updateOpenAmount(artikelId, newAmount) {
            console.log('UPDATE OPEN AMOUNT', newAmount);
            const artikel = this.getOpenArticle(artikelId);
            artikel.find('.anzahl-badge').text(newAmount);

            artikel.attr('data-artikel-anzahl', newAmount);
        }

        updateAssignedAmount(event) {
            console.log('UPDATE ASSIGNED AMOUNT');
            const artikelId = $(event.target.parentElement).data('artikel-id');
            const newAmount = event.target.value;
            const artikel = this.getAssignedArticle(artikelId);
            artikel.attr('data-artikel-anzahl', newAmount);

            const max = parseInt(artikel.find('input').attr('max'));
            const remaining = max - parseInt(newAmount);

            this.updateOpenAmount(artikelId, remaining);
        }

        createOpenItem(artikelId, artikelName, artikelAnzahl) {
            return $(`<li class="list-group-item d-flex justify-content-between align-items-center"
                        draggable="true" data-artikel-id="${artikelId}" data-artikel-name="${artikelName}"
                        data-artikel-anzahl="${artikelAnzahl}">
                        ${artikelName}
                        <span class="anzahl-badge  badge badge-primary badge-pill">${artikelAnzahl}</span>
                    </li>         
                    `);
        }

        createAssignedItem(artikelId, artikelName, artikelAnzahl) {
            const newItem = $(`<li class="list-group-item d-flex justify-content-between align-items-center"
                        draggable="true" data-artikel-id="${artikelId}" data-artikel-name="${artikelName}"
                        data-artikel-anzahl="${artikelAnzahl}">
                        ${artikelName}
                        <input id="artikelInput${artikelId}" type="number" class="form-control" value="${artikelAnzahl}" max="${artikelAnzahl}" min="0"/>
                    </li>         
                    `);
            newItem.find(`#artikelInput${artikelId}`).on('blur', (event) => this.updateAssignedAmount(event));
            newItem.find(`#artikelInput${artikelId}`).on('blur', (event) => this.preventWrongAmount(event));
            return newItem;
        }

        preventWrongAmount(event) {
            const max = parseInt($(event.target).attr('max'));
            const keyCode = event.keyCode !== 46 || keyCode !== 8;// keycode for delete and backspace

            if (event.target.value > max && keyCode) {
                event.preventDefault();
                $(event.target).val(max);
            } else if (event.target.value < 0 && keyCode || event.target.value === '') {
                $(event.target).val(0);
            }
            this.updateAssignedAmount(event);

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
