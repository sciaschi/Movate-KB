<template>
    <div id="detailsPanel" class="row p-3">
        <div class="col-8">
            <span id="detailsTerm" class="fs-1 fw-bold">
                <span>{{ term.term }}</span>
                <span id="detailRatingSpan" class="fs-4 term-rating ml-5 text-white" :class="'rating-' + term.rating">
                    {{ term.rating }}
                </span>
            </span>
        </div>
        <div class="col-4 text-end d-inline">
            <span id="edit-term-btn-container" class="fs-3">
                <primary-button @click="this.$parent.toggleEdit()" id="edit-term-btn" type="button" class="btn btn-outline-primary">
                    <i class="fa-regular fa-pen-to-square"></i>
                </primary-button>
            </span>
            <span id="detailsDateAdded">
                Created: {{ formatSelectedTermDate(term.created_at) }}
            </span>
        </div>
        <div class="col-12 mb-3 mt-3">
            <div id="detailsDescription" class="p-6 bg-white dark:bg-slate-800 border-b border-gray-200 h-100 w-100"
                 v-html="term.description">
            </div>
        </div>
        <div v-show="term.links ? term.links.length : false" class="col-12">
            <div id="detailsLinksTable">
                <table class="table-auto static-table">
                    <thead>
                    <tr>
                        <th class="rounded-t-lg">
                            Links
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="link in term.links">
                        <td>
                            <a :href="link.link_url" target="_blank">{{link.link_url}}</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";
import PrimaryButton from "@jsAssets/Shared/Widgets/primary-button.vue";

export default {
    name: "TermDetails",
    components: {PrimaryButton},
    props: {
        term: Object
    },
    methods: {
        formatSelectedTermDate: function (date) {
            return moment(date).format("MMMM Do YYYY");
        },
    }
}
</script>

<style scoped>

</style>
