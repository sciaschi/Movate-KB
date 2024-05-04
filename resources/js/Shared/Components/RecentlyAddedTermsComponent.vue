<template>
    <component-layout header="Recently Added Terms">
        <div id="recent-terms-container" class="p-2">
            <fx-table @vue:updated="tableMounted" :columns="columns" :data="terms"></fx-table>
            <div v-if="loading" class="overlay">
                <span class="lds-dual-ring"></span>
            </div>
        </div>
    </component-layout>
</template>

<script>
import * as bootstrap from 'bootstrap';
import route from "ziggy-js";
import moment from "moment";
import FxTable from "@jsAssets/Shared/Widgets/fx-table.vue";
import ComponentLayout from "@jsAssets/Shared/Widgets/Shared/dashboard-component-layout.vue";
import utils from "@jsAssets/utils";
import {Link} from "@inertiajs/inertia-vue3";
import {Inertia} from "@inertiajs/inertia";

export default {
    name: "RecentlyAddedTermsComponent",
    components: {ComponentLayout, FxTable, Link},
    data () {
        return {
            columns: [],
            terms: null,
            loading: true
        }
    },
    methods: {
        moment: function () {
            return moment;
        },
        pollData() {
            this.polling = setInterval(async () => {
                await this.getTerms();
            }, 60000)
        },
        getTerms: async function() {
            this.loading = true;

            let res = await axios.get(route('get-recently-added-terms'), {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if(res.status) {
                this.terms = res.data.terms;
                this.loading = false;

                this.setBindings();
            }
        },
        goToTerm: function(term) {
            Inertia.visit(route('terms', term))
        },
        setBindings: function() {
            let context = this;

            document.querySelectorAll('.term-link').forEach(function(link) {
                link.onclick = (el) => {
                    context.goToTerm(link.dataset.term)
                };
            })
        },
        tableMounted: function() {}
    },
    beforeMount() {
        this.columns = [
            {
                id: 'term',
                name: 'Term',
                render: function (data) {
                    return "<a class='term-link' data-term='"+data.term+"'>" + data.term + "</a>";
                },
            },
            {
                id: 'rating',
                name: 'Rule',
                render: function (data) {
                    return "<span class='ra-term-rating class-"+ data.rating +"'>" + utils.convertRating(data.rating) + "</span>";
                },
            }
        ];
    },
    beforeUnmount () {
        clearInterval(this.polling)
    },
    created () {
        this.pollData();
    },
    async mounted() {
        await this.getTerms();
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
