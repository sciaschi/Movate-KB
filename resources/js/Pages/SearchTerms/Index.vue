<template>
    <div class="overflow-hidden shadow-sm sm:rounded-lg w-100 d-inline-block" style="min-height: 100%;">
        <div class="p-6 h-100 w-100 d-inline-block">
            <div class="container row">
                <div id="username_sidebar" class="col-xs-12 col-sm-12 col-md-4 bg-light shadow-sm sm:rounded-lg dark:bg-slate-700 dark:text-slate-400">
                    <div class="input-group mb-3">
                        <input @keyup="searchTrigger.invoke($event.target.value)" @keyup.delete="searchTrigger.invoke($event.target.value)"
                               id="search-input" type="text" class="form-control search-input" placeholder="Search for term..."
                               aria-describedby="search-input-button">
                        <button @click="openAddTermModal()" class="btn btn-outline-light bg-primary" type="button" id="search-input-button">
                            <i class="fa-solid fa-plus"></i>
                        </button>
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
                    <div id="term-details" class="bg-light shadow-sm sm:rounded-lg w-100 dark:bg-slate-700 dark:text-slate-400" style="min-height: 100%;">
                        <component  @updateEditTerm="updateEditTerm" v-if="selectedTerm" :is="editing ? 'term-edit' : 'term-details'" :term="selectedTerm"></component>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {MeiliSearch} from "meilisearch";
import TermDetails from "./TermDetails";
import moment from 'moment';
import TermEdit from "./TermEdit";
import {usePage} from "@inertiajs/inertia-vue3";
import Swal from 'sweetalert2';

export default {
    name: "Index",
    components: {
        TermEdit,
        TermDetails
    },
    data () {
        return {
            editing: false,
            searchTerms: [],
            selectedTerm: null,
            client: null,
            searchTrigger: null
        }
    },
    methods: {
        setSelectedItemBg: function(el) {
            var curSel = document.querySelector('.term_search_value.active')

            if(curSel) {
                curSel.classList.remove('active');
            }

            el.classList.add('active');
        },
        toggleEdit: function() {
            this.editing = !this.editing;
        },
        setSelectedTerm: function(term, el) {
            this.selectedTerm = term;
            this.editing      = false;

            this.setSelectedItemBg(el);
        },
        getAllTerms: function() {
            var context = this;

            console.log("Updating all terms");

            $.ajax({
                async: false,
                method: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/term/get-all-terms"
            })
            .done((data) => {
                context.searchTerms = data;
                context.client.index('terms').addDocuments(context.searchTerms);
            });
        },
        searchTerm: function(text) {
            var context = this;

            if(!text.length) {
                return this.getAllTerms();
            }

            this.client.index('terms').updateSettings({
                searchableAttributes: [
                    'term'
                ]
            });

            return this.client.index('terms').search(text, {
                limit: 50
            }).then(function(data) {
                context.searchTerms = data.hits;
            });
        },
        updateEditTerm: function(term) {
            var termIndex = this.searchTerms.findIndex(x => x.id === term.id);

            this.searchTerms[termIndex] = term;
            this.selectedTerm = term;
            this.toggleEdit();
        },
        openAddTermModal: function() {
            const context = this;

            const {value: formValues} = Swal.fire({
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
                    '<div class="col-12 mt-2"><div id="linksTable"><table class="table-auto static-table">' +
                    '<thead>' +
                    '<tr>' +
                    '<th class="rounded-t-lg">' +
                    '  Links' +
                    '</th>' +
                    '<th class="rounded-t-lg">' +
                    'Actions' +
                    '</th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody>' +
                    '<tr v-for="(link, index) in links">' +
                    '<td>' +
                    '{{ link.link_url }}' +
                    '</td>' +
                    '<td>' +
                    '<button class="btn btn-primary" @click="removeLink(index)"><i class="fa-solid fa-xmark"></i></button>' +
                    '</td>' +
                    '</tr>' +
                    '</tbody>' +
                    '</table></div></div>' +
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
                        description: document.getElementById('description').value,
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
                    .done(function (msg) {
                        console.log(msg);
                        // context.searchTerms.push(data.term);
                        // context.client.index('terms').addDocuments(context.searchTerms);
                    });
                }
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                } else if (result.isDenied) {
                    Swal.fire('Changes were not saved', '', 'info')
                }
            });

            if (formValues) {
                Swal.fire(JSON.stringify(formValues));
            }

            document.getElementById("addWebAddress_Btn").addEventListener('click', (e) => {
                var val = document.getElementById("webAddress_val").value;
                this.links.push([val]);
            });
        }
    },
    beforeUnmount: function() {

    },
    mounted: function() {
        var host = location.hostname + ':7700';
        this.client = new MeiliSearch({ host: host });

        this.getAllTerms();

        this.searchTrigger = new utils.rollingTrigger(this.searchTerm, 500);
    },
    activated: function() {
    }
}
</script>

<style scoped>

</style>
