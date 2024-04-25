<template>
    <div class="overflow-hidden shadow-sm sm:rounded-lg w-100 d-inline-block">
        <div class="p-6 h-100 w-100 d-inline-block" style="min-height: 85vh;">
            <div class="container row">
                <div id="username_sidebar" class="col-xs-12 col-sm-12 col-md-4 bg-light shadow-sm sm:rounded-lg dark:bg-slate-700 dark:text-slate-400" style="height:88vh; overflow-y: auto">
                    <div class="input-group mb-3 mt-3">
                        <input @keyup="searchTrigger.invoke($event.target.value)" @keyup.delete="searchTrigger.invoke($event.target.value)"
                               id="search-input" type="text" class="form-control search-input" placeholder="Search for term..."
                               aria-describedby="search-input-button">
                        <primary-button @click="this.adding = true" class="btn btn-outline-light bg-primary" type="button" id="search-input-button">
                            <i class="fa-solid fa-plus"></i>
                        </primary-button>
                    </div>
                    <div id="search_results_div">
                        <ul id="search_results" class="list-group list-group-flush" role="tablist">
                            <a @click="setSelectedTerm(searchTerm, $event.target)" class='active:bg-indigo-300
                            dark:bg-slate-800 dark:text-slate-400 dark:border dark:border-slate-700 list-group-item
                            list-group-item-action term_search_value' v-for="searchTerm in searchTerms">{{ searchTerm.term }}</a>
                        </ul>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8">
                    <div id="term-details" class="bg-light shadow-sm sm:rounded-lg w-100 dark:bg-slate-700 dark:text-slate-400" style="height:88vh; overflow-y: auto; padding:10px;">
                        <component @addNewTerm="addNewTerm"  @updateEditTerm="updateEditTerm"  v-if="adding || selectedTerm"
                                    :adding="adding" :is="editing || adding ? 'term-edit' : 'term-details'"
                                    :term="selectedTerm">
                        </component>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {MeiliSearch} from "meilisearch";
import TermDetails from "./TermDetails";
import TermEdit from "./TermEdit";
import route from "ziggy-js";
import utils from "@jsAssets/utils";
import PrimaryButton from "@jsAssets/Shared/Widgets/primary-button.vue";

export default {
    name: "Index",
    components: {
        PrimaryButton,
        TermEdit,
        TermDetails
    },
    data () {
        return {
            editing: false,
            adding: false,
            searchTerms: [],
            selectedTerm: null,
            searchTrigger: null
        }
    },
    methods: {
        setSelectedItemBg: function (el) {
            var curSel = document.querySelector('.term_search_value.active')

            if (curSel) {
                curSel.classList.remove('active');
            }

            el.classList.add('active');
        },
        toggleEdit: function () {
            this.editing = !this.editing;
        },
        setSelectedTerm: function (term, el) {
            this.selectedTerm = term;
            this.editing      = false;
            this.adding       = false;

            this.setSelectedItemBg(el);
        },
        getAllTerms: async function () {
            var res = await axios.get(route('get-all-terms'),{
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            });

            this.searchTerms = res.data;
        },
        searchTerm: async function (text) {
            if (!text.length) {
                return this.getAllTerms();
            }

            let res = await axios.post(route('search-term'), {
                searchTerm: text
            })

            this.searchTerms = res.data.result.hits;
        },
        updateEditTerm: function (term) {
            var termIndex = this.searchTerms.findIndex(x => x.id === term.id);

            this.searchTerms[termIndex] = term;
            this.selectedTerm           = term;
            this.toggleEdit();
        },
        addNewTerm: function (newTerm) {
            this.searchTerms.push(newTerm);
            this.searchTerms.sort((a, b) => a.term.localeCompare(b.term));
            this.client.index('terms').addDocuments(newTerm);
            this.adding = false;
        }
    },
    beforeUnmount: function() {

    },
    created: function() {

    },
    mounted: async function() {
        await this.getAllTerms();
        this.searchTrigger = new utils.rollingTrigger(this.searchTerm, 500);
    }
}
</script>

<style scoped>
    #term-details {
        overflow-x: hidden;
    }
    #search-input-button {
        height:unset;
        border-top-left-radius: 0!important;
        border-bottom-left-radius: 0!important;
    }
</style>
