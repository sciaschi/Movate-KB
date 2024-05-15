<template>
    <component-layout header="Recent Terms">
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
            terms: [],
            loading: true
        }
    },
    methods: {
        moment: function () {
            return moment;
        },
        getTerms: async function() {
            this.loading = true;

            let res = await axios.get(route('get-recently-added-terms'), {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if(res.data.status) {
                this.terms = Object.keys(res.data.terms).map((k) => res.data.terms[k]);
                this.loading = false;
            }
        },
        goToTerm: function(term) {
            Inertia.visit(route('terms', term))
        },
        setBindings: function() {
            document.querySelectorAll('.term-link').forEach((link) => {
                link.onclick = () => {
                    this.goToTerm(link.dataset.term)
                };
            })
        },
        tableMounted: function() {
            this.setBindings();
        }
    },
    async beforeMount() {
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

        await this.getTerms();

        var channel = Echo.channel('recent-terms');
        channel.listen('UpsertTermEvent', (e) => {
            console.log(e);
            this.terms = e.terms;
        })
    }
}
</script>

<style scoped>

</style>
