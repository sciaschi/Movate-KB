var dashboard = {
    init: function() {
        moment.updateLocale("en", {
            relativeTime: {
                future: "in %s",
                past: "%s ago",
                s: "1 sec",
                ss: "%d sec",
                m: "%d min",
                mm: "%d mins",
                h: "%d hr",
                hh: "%d hrs",
                d: "%d d",
                dd: "%d d",
                M: "a mth",
                MM: "%d mths",
                y: "yr",
                yy: "%d yrs"
            }
        });

        this.initRecentTermsGrid();
        this.refreshTrends();
        this.initBindings();
    },

    initBindings: function() {
        let context = this;

        document.getElementById('add-trend-btn').addEventListener('click', function(e) {
            context.openAddTermModal();
        });

        Livewire.hook('message.processed', (message, component) => {
            context.initRecentTermsGrid();
        })
    },

    initRecentTermsGrid: function() {
        let termObjs         = document.getElementsByClassName('recentlyAddedTermDate'),
            existingPopover = document.querySelector('.popover');

        if(existingPopover)
        {
            existingPopover.remove();
        }

        Array.from(termObjs).forEach(element => {
            element.innerHTML = moment.utc(element.innerHTML).fromNow();
        });

        let termRatingObjs = document.getElementsByClassName('recentlyAddedTermRating')

        for(let index = 0;index < termRatingObjs.length;index++)
        {
            let element = termRatingObjs[index];
            utils.setColorByNumber(element.innerHTML, element);
        }

        const popoverTriggerList = $('[data-bs-toggle="popover"]');

        for(var i = 0; i < popoverTriggerList.length; i++) {
            var el = popoverTriggerList[i];

            var tt = new bootstrap.Popover(el, {
                html: true,
                trigger: 'hover focus',
                delay: 1000
            });
        }
    },

    refreshTrends: function() {
        var trendSpinner    = document.getElementById('trend-spinner'),
            trendGrid       = document.getElementById('trends-grid');

        trendSpinner.classList.add('d-flex');
        trendSpinner.classList.remove('d-none');
        trendGrid.classList.add('d-none');

        trendGrid.innerHTML = "";

        $.ajax({
            async: true,
            method: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/trend/get-trends",
            data: {
                'count': 6
            }
        })
        .done(function( data ) {
            var trends = data['trends'];

            for(var i = 0; i < trends.length; i++) {
                var trend = trends[i],
                    html = '<div class="col-md-6 col-sm-12 col-lg-4 col-xl-4 d-flex align-items-stretch pb-2">' +
                                `<a href="${trend.url}" target="_blank" class="d-flex align-items-stretch">` +
                                    '<div class="card h-100 dark:bg-slate-700 dark:text-slate-400" style="width: 23rem; margin-top:10px;">' +
                                        `<img src="${trend.image}" class="card-img-top">` +
                                        '<div class="card-body">' +
                                            `<p class="card-text">${trend.title}</p>` +
                                        '</div>' +
                                    '</div>' +
                                '</a>' +
                            '</div>';

                trendGrid.innerHTML += html;
            }

            trendSpinner.classList.remove('d-flex');
            trendSpinner.classList.add('d-none');

            trendGrid.classList.remove('d-none');
        });
    },

    openAddTermModal: function() {
        const context = this;

        Swal.fire({
            title: 'Add Trending News Article',
            html:
                '<input type="text" id="url-val" class="form-control" placeholder="Enter Web address..." aria-label="Enter Web address...">',
            focusConfirm: false,
            confirmButtonText: 'Save',
            showCancelButton: true,
            width: 1000,
            preConfirm: () => {
                var inputData = {
                    url: document.getElementById('url-val').value.toString(),
                };

                $.ajax({
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/trend/store",
                    data: inputData
                }).done(function( data ) {
                    if(data.responseJSON.status)
                    {
                        Swal.fire('Saved!', '', 'success')
                        return context.refreshTrends();
                    }
                    return false
                })
                .catch(error => {
                    var data = error.responseJSON;

                    Swal.fire({
                        icon: 'error',
                        title: "Failed",
                        text: `${data.message}`
                    })
                });
            }
        });
    }
}
