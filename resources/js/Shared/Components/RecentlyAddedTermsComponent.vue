<template>
    <div class="py-12 col-6">
        <div class="max-w-7 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-slate-800 dark:border-none">
                    <h2 class="header-text text-gray-800 font-semibold dark:text-slate-400 leading-tight dark:border-b-2 dark:border-indigo-600">
                        Recently Added Terms
                    </h2>
                </div>
                <div id="recent-terms-container" class="container pt-3">
                    <div id="rt-grid" class="row align-items-stretch" v-if="!isLoading">
                        <div class="col-md-6 col-sm-12 col-lg-4 col-xl-4 h-100 mb-3 align-middle" v-for="term in terms">
                            <div class="card ra-term dark:bg-slate-700 dark:text-slate-400" data-bs-toggle="popover" data-bs-placement="top"
                                 :data-bs-title="term.term"
                                 :data-bs-content="term.description"
                                 :data-id="term.id">
                                <div class="card-body">
                                    <div style="padding-bottom: 5px;">
                                        <span>{{ term.term }}</span>
                                        <span :class="'rating-'+term.rating" class="ra-term-rating text-white dark:dark:text-slate-600 float-end">{{ term.rating }}</span>
                                    </div>
                                    <div class="ra-term-date">
                                        <span>{{ moment().utc(term.created_at).fromNow() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import * as bootstrap from 'bootstrap';

export default {
    name: "RecentlyAddedTermsComponent",
    data () {
        return {
            terms: null,
            isLoading: false
        }
    },
    methods: {
        moment: function () {
            return moment;
        },
        pollData () {
            this.polling = setInterval(() => {
                this.getTerms();
            }, 60000)
        },
        getTerms: function() {
            var context = this;

            $.ajax({
                async: true,
                method: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/term/get-recently-added-terms"
            })
            .done(function( data ) {
                if(data.status) {
                    context.terms = data.terms;
                }
            });
        }
    },
    beforeUnmount () {
        clearInterval(this.polling)

    },
    created () {
        this.pollData();
        this.getTerms();
    },
    updated() {
        const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]'),
              existingPopover    = document.querySelector('.popover');

        if(existingPopover)
        {
            existingPopover.remove();
        }

        for(var i = 0; i < popoverTriggerList.length; i++) {
            var el = popoverTriggerList[i];

            new bootstrap.Popover(el, {
                html: true,
                trigger: 'hover focus',
                delay: 1000
            });
        }
    }
}
</script>

<style scoped>

</style>
