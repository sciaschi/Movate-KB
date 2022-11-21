<template>

    <div id="recent-terms-container" class="container pt-3">
        <div v-if="isLoading" id="trend-spinner" class="d-flex justify-content-center">
            <div class="spinner-grow text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div id="rt-grid" class="row align-items-stretch" v-if="!isLoading">
            <div class="col-md-6 col-sm-12 col-lg-4 col-xl-4 h-100 mb-3 align-middle" v-for="term in terms">
                <div class="card ra-term dark:bg-slate-700 dark:text-slate-400" data-bs-toggle="popover" data-bs-placement="top"
                     :data-bs-title="term.term"
                     :data-bs-content="term.description"
                     :data-id="term.id">
                    <div class="card-body">
                        <span class="ra-term-date float-end w-30">{{ moment().utc(term.created_at).fromNow() }}</span>
                        <span>{{ term.term }}</span> <span :class="'rating-'+term.rating" class="ra-term-rating text-white dark:dark:text-slate-600 float-end">{{ term.rating }}</span>
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
    beforeDestroy () {
        clearInterval(this.polling)
    },
    created () {
        this.pollData();
    },
    mounted() {
        this.getTerms();

        let existingPopover = document.querySelector('.popover');

        if(existingPopover)
        {
            existingPopover.remove();
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
    }
}
</script>

<style scoped>

</style>
