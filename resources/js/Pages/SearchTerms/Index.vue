<template>
    <div class="overflow-hidden shadow-sm sm:rounded-lg w-100 d-inline-block">
        <div class="mt-6 h-100 w-100 d-inline-block" style="min-height: 85vh;">
            <div class="container row">
                <div id="username_sidebar" class="col-xs-12 col-sm-12 col-md-4 bg-light shadow-sm sm:rounded-lg dark:bg-slate-700 dark:text-slate-400">
                    <div class="input-group mb-3 mt-3">
                        <input @keyup="searchTrigger.invoke($event.target.value)" @keyup.delete="searchTrigger.invoke($event.target.value)"
                               id="search-input" type="text" class="form-control search-input" placeholder="Search for term..."
                               aria-describedby="search-input-button" :disabled="loading">
                        <primary-button @click="this.adding = true" :disabled="loading" class="btn btn-outline-light bg-primary" type="button" id="search-input-button">
                            <i class="fa-solid fa-plus"></i>
                        </primary-button>
                    </div>
                    <div id="search_results_div">
                        <ul v-if="isSearchEmpty" id="search_results" class="list-group list-group-flush" role="tablist">
                            <li v-for="category in searchCategories">
                                <fx-accordion :id="category.name" :title="category.name">
                                    <div @click="setSelectedTerm(searchTerm, $event.target)" class='active:bg-indigo-300
                                        dark:bg-slate-800 dark:text-slate-400 dark:border dark:border-slate-700 list-group-item
                                        list-group-item-action term_search_value ' v-for="searchTerm in category.terms">
                                        {{ searchTerm.term }}
                                    </div>
                                </fx-accordion>
                            </li>
                        </ul>
                        <ul v-else id="search_results" class="list-group list-group-flush" role="tablist" :class="searchLoading ? 'overflow-hidden' : ''">
                            <li @click="setSelectedTerm(searchTerm, $event.target)" class='active:bg-indigo-300
                            dark:bg-slate-800 dark:text-slate-400 dark:border dark:border-slate-700 list-group-item
                            list-group-item-action term_search_value' v-for="searchTerm in searchTerms">{{ searchTerm.term }}</li>
                        </ul>
                        <div v-if="searchLoading" class="overlay">
                            <span class="lds-dual-ring"></span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8 position-relative">
                    <div id="term-details" class="bg-light dark:bg-slate-700 shadow-sm sm:rounded-lg w-100 dark:text-slate-400"
                         style="height:88vh; overflow-y: auto; padding:10px;" :class="!adding && !selectedTerm ? 'flex items-center justify-center' : ''">
                        <component @addNewTerm="addNewTerm"  @updateEditTerm="updateEditTerm" @loading="isLoading"  v-if="adding || selectedTerm"
                                    :adding="adding" :is="editing || adding ? 'term-edit' : 'term-details'"
                                    :term="selectedTerm" :categories="categories">
                        </component>
                        <span v-else class="text-lg">Select a term from the search box for more details</span>
                    </div>
                    <div v-if="loading" class="overlay">
                        <span class="lds-dual-ring"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TermDetails from "./TermDetails";
import TermEdit from "./TermEdit";
import route from "ziggy-js";
import utils from "@jsAssets/utils";
import PrimaryButton from "@jsAssets/Shared/Widgets/primary-button.vue";
import FxAccordion from "@jsAssets/Shared/Widgets/fx-accordion.vue";

export default {
    name: "Index",
    components: {
        FxAccordion,
        PrimaryButton,
        TermEdit,
        TermDetails
    },
    props: {
        categories: Object,
        routeTerm: Object,
    },
    data () {
        return {
            editing: false,
            adding: false,
            loading: false,
            searchLoading: false,
            isSearchEmpty: true,
            searchCategories: [],
            searchTerms: [],
            searchTrigger: null,
            selectedTerm: null,
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
        isLoading: function(e) {
            this.loading = e;
        },
        setSelectedTerm: function (term, el) {
            if(this.loading) {
                return
            }

            this.selectedTerm = term;
            this.editing      = false;
            this.adding       = false;

            this.setSelectedItemBg(el);
        },
        getAllTerms: async function () {
            var res = await axios.get(route('get-all-terms-categories'),{
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            });

            this.searchCategories = res.data['categories'];

            let uncatIndex = this.searchCategories.findIndex(x => {
                return x.name === "Uncategorized"
            });

            if(uncatIndex === -1) {
                this.searchCategories.push({
                    name:"Uncategorized", terms: Object.keys(res.data['uncategorized']).map((k) => res.data['uncategorized'][k])
                })
            }

            this.searchTerms = res.data['all'];

            this.searchCategories.forEach(function(cat) {
                cat.terms.sort((a,b) => a.term.localeCompare(b.term))
            })

            this.searchLoading = false;
        },
        searchTerm: async function (text) {
            this.searchLoading = true;

            if (!text.length) {
                this.isSearchEmpty = true;
                this.searchTerms = []
                this.searchLoading = false;
                return;
            }

            let res = await axios.post(route('search-term'), {
                searchTerm: text
            })

            this.searchTerms = res.data.result.hits;
            this.searchLoading = false;
            this.isSearchEmpty = false;
        },
        updateEditTerm: function (term) {
            let searchCatIndex = this.searchCategories.findIndex(x => {
                return x.terms.find(i => i.id === term.id)
            })

            let termIndex = this.searchCategories[searchCatIndex].terms.findIndex(x => x.id === term.id)
            let searchTermIndex = this.searchTerms.findIndex(x => x.id === term.id);

            if(term.category) {
                let catIndex = this.searchCategories.findIndex(x => {
                    return x.id.toString() === term.category
                })

                this.searchCategories[catIndex].terms.push(term)
            } else {
                let catIndex = this.searchCategories.findIndex(x => {
                    return x.name === 'Uncategorized'
                })

                this.searchCategories[catIndex].terms.push(term)
            }

            this.searchCategories[searchCatIndex].terms.splice(termIndex, 1);

            this.searchCategories.forEach(function(cat) {
                cat.terms.sort((a,b) => a.term.localeCompare(b.term))
            })
            console.log(term);
            this.searchTerms[searchTermIndex] = term
            this.selectedTerm = term;

            this.toggleEdit();
        },
        addNewTerm: function (newTerm) {
            this.searchTerms.push(newTerm);
            this.searchTerms.sort((a, b) => a.term.localeCompare(b.term));
            this.client.index('terms').addDocuments(newTerm);
            this.adding = false;
        }
    },
    beforeMount: function() {
        if(this.routeTerm) {
            this.selectedTerm = this.routeTerm;
        }

        this.searchLoading = true;
        this.getAllTerms();
        this.searchTrigger = new utils.rollingTrigger(this.searchTerm, 500);
    }
}
</script>

<style scoped>
    #search_results {

    }
    #term-details {
        overflow-x: hidden;
    }
    #search-input-button {
        height:unset;
        border-top-left-radius: 0!important;
        border-bottom-left-radius: 0!important;
    }
    #username_sidebar {
        position:relative;
        height:88vh;
        overflow-y: auto
    }
</style>
