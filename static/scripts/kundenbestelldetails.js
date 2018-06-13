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

    const bestellId = getQueryVariable('id');
    $('#bestellID').val(bestellId);

    $.ajax({
        url: '../php/kundenbestelldetails/getKundenName.php?id=' + bestellId
    }).done(data => {
        lieferantInput.val(data);
    });

    loadData();

    function loadData() {
        artikelTable.load('../php/kundenbestelldetails/artikelTable.php?id=' + bestellId, () => {

        });

        lieferungenTable.load('../php/kundenbestelldetails/getLieferungen.php?id=' + bestellId, () => {

        });
    }

    /* MODAL */
    const modal = $('#modal');

    let modalInstanz = null;

    modal.on('show.bs.modal', (event) => {
        const button = $(event.relatedTarget);

        modalInstanz = new LieferungHinzufuegenModal(bestellId);

    });


    class LieferungHinzufuegenModal {

        constructor(bestellId) {
            this.OFFENEARTIKELID = 'offeneArtikel';
            this.ZUGEORDNETEARTIKELID = 'zugeordneteArtikel';

            // DROP ZONES
            this.offeneArtikelContainer = $('#offeneArtikel');
            this.zugeordneteArtikelContainer = $('#zugeordneteArtikel');
            this.lastEnter = null;

            this.saveBtn = $('#saveBtn');
            this.saveBtn.unbind('click');
            this.saveBtn.on('click', () => this.saveLieferung());

            this.offeneArtikelContainer.load('../php/kundenbestelldetails/getOffeneArtikel.php?id=' + bestellId, () => {
                this.setupDragAndDrop();
            });
        }


        setupDragAndDrop() {
            this.offeneArtikel = this.offeneArtikelContainer.find('.list-group-item');
            this.zugeordneteArtikel = this.zugeordneteArtikelContainer.find('.list-group-item');

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
            if (event == null) return;
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
            if (this == null) return;
            $(this).removeClass('drag-held');
            $(this.parentElement).removeClass('drag-over');
        }


        handleDropOpen(dropZone, artikel) {
            if (dropZone.attr('id') === this.OFFENEARTIKELID) {

                // const newItem = this.createOpenItem(artikel.artikelId, artikel.artikelName, artikel.artikelAnzahl);
                // dropZone.append(newItem);
                const assignedItem = this.getAssignedArticle(artikel.artikelId);
                this.removeAssignedItem(assignedItem);

            }
        }

        handleDropAssigned(dropZone, artikel) {
            if (dropZone.attr('id') === this.ZUGEORDNETEARTIKELID) {

                if (!this.isAssigned(artikel.artikelId)) {
                    const newItem = this.createAssignedItem(artikel.artikelId, artikel.artikelName, artikel.artikelAnzahl);
                    $('.dnd-info').hide();
                    dropZone.append(newItem);
                    this.updateOpenAmount(artikel.artikelId, 0);
                    newItem.find('input').focus()
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
            const artikel = this.getOpenArticle(artikelId);
            artikel.find('.anzahl-badge').text(newAmount);

            artikel.attr('data-artikel-anzahl', newAmount);
        }

        updateAssignedAmount(event) {
            const artikelId = $(event.target.parentElement).data('artikel-id');
            const newAmount = event.target.value;
            const artikel = this.getAssignedArticle(artikelId);
            artikel.attr('data-artikel-anzahl', newAmount);

            const max = parseInt(artikel.find('input').attr('max'));
            const remaining = max - parseInt(newAmount);

            this.updateOpenAmount(artikelId, remaining);

            // Remove assigned item if assigned amount is 0 (therefore nothing's assigned)
            if (parseInt(newAmount) === 0) {
                this.removeAssignedItem(event.target.parentElement);
            }
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
            this.setupDragAndDropEvents(newItem);
            return newItem;
        }

        removeAssignedItem(item) {
            const artikelId = $(item).data('artikel-id');
            const max = $(item).find('input').attr('max');

            $(item).remove();
            this.updateOpenAmount(artikelId, max);
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
                bestellungsId: $('#bestellID').val(),
                lieferantID: $('#lieferant').val(),
                artikel: []
            };

            const artikelItems = $('#zugeordneteArtikel .list-group-item');
            artikelItems.map((idx, value) => {

                const artikel = $(value);
                lieferung.artikel.push({
                    artikelId: artikel.data('artikel-id'),
                    artikelName: artikel.data('artikel-name'),
                    artikelAnzahl: artikel.data('artikel-anzahl')
                });
            });

            if (lieferung.artikel.length === 0) return;

            $.ajax({
                method: "POST",
                url: '../php/kundenbestelldetails/saveAssignedArticles.php',
                data: lieferung,
                success: (result) => {
                    if (result == "true") {
                        modal.modal('hide');
                        console.log('saved successfully!');
                        loadData();
                        createNotifiction('Kundenlieferung wurde erfolgreich hinzugefügt', true);
                    }
                    else {
                        console.error('save failed');
                        loadData();
                        createNotifiction(result, false);
                    }
                },
                error: (error) => {
                    console.error('error', error);
                    loadData();
                    createNotifiction('Kundenlieferung konnte nicht hinzugefügt werden.', false);
                }
            });
        }
    }

// BEGIN DRAG AND DROP

    // END DRAG AND DROP

})();
