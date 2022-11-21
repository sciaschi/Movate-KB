var Search = {
    client: null,
    terms: [],
    selectedId: 0,
    selectedResult: {},
    links: [],
    linksTable: '<table id="links_table" class="table"></table>',
    linkGrid: null,
    editLinkGrid: null,
    activeState: 'view',

    init: function() {
        this.initBindings();
        jQuery('#detailsDescription').hide();
        this.linkGrid = null;
        this.editLinkGrid = null;
    },

    initBindings: function() {
        var context = this;

        jQuery('#search_results').on('click', '.term_search_value', function(e) {
            var activeTerm = document.querySelector('.term_search_value.active');

            if(context.activeState == 'edit')
            {
                context.toggleViewEdit('view');
                context.editLinkGrid = null;
                tinymce.remove('#edit-description');

                return true;
            }
            context.selectedId = e.target.dataset.id;
        });

        Livewire.hook('message.processed', (message, component) => {
            if(context.activeState == "view")
            {
                context.initViewBindings();
                document.querySelector('#edit-term-btn-container').classList.remove('invisible')
                context.editLinkGrid = null;
            }
            else if(context.activeState == 'edit')
            {
                context.initEditBindings();
                context.linkGrid = null;
            }
        });

        jQuery("#search-input-button").on('click', function() {

            Search.openAddTermModal();

            utils.setColorByRangeNumber("rating", "rangeval");

            document.getElementById("rating").addEventListener('input',function() {
                var val = $(this).val();

                $("#rangeval").html(val);
                utils.setColorByRangeNumber("rating", "rangeval");
            });

            tinymce.init({
                selector: 'textarea#description',
                height: 500,
                icons: 'bootstrap',
                plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks ' +
                    'visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor ' +
                    'insertdatetime advlist lists wordcount help charmap quickbars emoticons',
                toolbar: 'undo redo | blocks | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                content_style: 'body { font-size:16px }',
                table_default_attributes: {
                    class: 'table table-bordered table-striped rounded'
                },
                table_default_styles: {
                    overflow: 'hidden'
                },
                table_header_type: 'auto'
            });
        });
    },

    initViewBindings: function() {
        var context = this,
            detailRatingSpan    = document.getElementById('detailRatingSpan'),
            detailDateSpan      = document.getElementById('detailsDateAdded');

        document.getElementById('edit-term-btn').addEventListener('click', function() {
            context.toggleViewEdit('edit');
        });

        detailDateSpan.innerHTML = "Added " + moment(detailDateSpan.innerHTML).format('MMM Do YYYY');
        utils.setColorByNumber(detailRatingSpan.innerHTML, detailRatingSpan);
    },

    initEditBindings: function() {
        var context         = this,
            editRatingSpan  = document.getElementById('edit-rangeval'),
            editDateSpan    = document.getElementById('edit-date'),
            editLinks       = [];

        utils.setColorByNumber(editRatingSpan.innerHTML, editRatingSpan);
        editDateSpan.innerHTML = moment(editDateSpan.innerHTML).format('MMM Do YYYY');

        document.getElementById("edit-rating").addEventListener('input',function() {
            var val = $(this).val();

            $("#edit-rangeval").html(val);
            utils.setColorByRangeNumber("edit-rating", "edit-rangeval");
        });

        tinymce.init({
            selector: 'textarea#edit-description',
            height: 500,
            icons: 'bootstrap',
            plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks ' +
                'visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor ' +
                'insertdatetime advlist lists wordcount help charmap quickbars emoticons',
            toolbar: 'undo redo | blocks | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body { font-size:16px }',
            table_default_attributes: {
                class: 'table table-bordered table-striped rounded'
            },
            table_default_styles: {
                overflow: 'hidden'
            },
            table_header_type: 'auto'
        });

        document.getElementById("save-term-edit-btn").addEventListener('click', function() {
            console.log(editLinks);
            var inputData = {
                id: selectedId,
                term: document.getElementById('edit-term-val').value,
                rating: document.getElementById('edit-rating').value,
                description: tinymce.get("edit-description").getContent(),
                links: editLinks
            };

            context.updateTerm(JSON.stringify(inputData));
            context.toggleViewEdit('view');

            tinymce.remove('#edit-description');
        });
    },

    toggleViewEdit: function(state) {
        this.activeState = state
        //Livewire.emit('setActiveState', state);
    },

    getAllTerms: function() {
        $.ajax({
            async: false,
            method: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/term/get-all-terms"
        })
        .done((data) => this.getAllTermsCallback(data));
    },

    getAllTermsCallback: function(data) {
        this.terms = data;
        this.client.index('terms').addDocuments(this.terms);
    },

    getSelectedTermDetails: function(termId) {
        return this.terms.find(x => x.id == termId ?? this.selectedId);
    },

    openAddTermModal: function() {
        const context = this;

        const { value: formValues } = Swal.fire({
            title: 'Add a Term',
            html:
                '<div id="addTermModalContent">' +
                    '<div class="row">' +
                        '<div class="col-6 mt-2">' +
                            '<label for="rating" class="form-label">Rating <span id="rangeval">1</span></label>' +
                            '<input type="range" class="form-range" min="1" max="8" id="rating" value="1">' +
                        '</div>' +
                        '<div class="col-6  mt-2">' +
                            '<span>Date</span>' +
                            `<p id="date" class="fs-6">${moment().format('MMMM Do YYYY')}</p>` +
                        '</div>' +
                        '<div class="col-12  mt-2">' +
                            '<input id="term_val" class="addUnTextInput form-control" placeholder="Term">' +
                        '</div>' +
                        '<div class="col-12  mt-2">' +
                            '<textarea id="description" class="form-control" rows="3" placeholder="Notes/Nuances (if any)"></textarea>' +
                        '</div>' +
                        '<div class="col-6 mt-2 float-right">' +
                            '<div class="input-group">' +
                                '<input type="text" id="webAddress_val" class="form-control" placeholder="Enter Web address..." aria-label="Enter Web address..." aria-describedby="addWebAddress_Btn">' +
                                '<button class="btn btn-outline-secondary" type="button" id="addWebAddress_Btn"><i class="fa-solid fa-plus"></i></button>' +
                            '</div>' +
                        '</div>' +
                        '<div class="col-12 mt-2"><div id="linksTable"></div></div>' +
                    '</div>' +
                '</div>',
            focusConfirm: false,
            confirmButtonText: 'Save',
            showCancelButton: true,
            width: 1000,
            preConfirm: () => {
                var inputData = {
                        term: document.getElementById('term_val').value,
                        rating: document.getElementById('rating').value,
                        description: tinymce.get("description").getContent(),
                        links: this.links
                };

                $.ajax({
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/search-term/store",
                    data: inputData
                })
                .done(function( data ) {
                    if(data && data.data)
                    {
                        context.terms.push(data.data);
                        context.refreshSearchTerms();
                        context.setSelectedResult(data.data);
                    }
                });
            }
        }).then((result) => {
            tinymce.remove('#description');

            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                Swal.fire('Term was saved successfully!', '', 'success')
            } else if (result.isDenied) {
              Swal.fire('Term was not saved!', '', 'error')
            }
          });

        if (formValues) {
            Swal.fire(JSON.stringify(formValues));
        }

        var grid = new gridjs.Grid({
            columns: ["Links"],
            data: this.links
          }).render(document.getElementById("linksTable"));

        document.getElementById("addWebAddress_Btn").addEventListener('click', (e) => {
            var val = document.getElementById("webAddress_val").value;
            this.links.push([val]);
            grid.updateConfig({
                data: this.links
              }).forceRender();
        });
    }
}
