<template>
    <div id="detailsPanel" class="row p-3">
        <div class="col-12">
            <span id="detailsTerm" class="fs-1 fw-bold">
                <span>{{ term.term }}</span>
                <span id="detailRatingSpan" class="fs-4 term-rating ml-5 text-white" :class="'class-' + term.rating">
                    {{ utils().convertRating(term.rating) }}
                </span>
            </span>
            <span id="edit-term-btn-container" class="fs-3">
                <primary-button @click="this.$parent.toggleEdit()" id="edit-term-btn" type="button" class="btn btn-outline-primary float-right">
                    <i class="fa-regular fa-pen-to-square"></i>
                </primary-button>
            </span>
        </div>
        <div class="col-12 mb-3 mt-3">
            <div id="detailsDescription" class="p-6 bg-white dark:bg-slate-800 border-b border-gray-200 h-100 w-100"
                 v-html="term.description">
            </div>
        </div>
        <div class="col-12">
            <fx-table :columns='[
                {
                    id: "link_url",
                    name: "Sources",
                    render: function(el) {
                        return "<a href=" + el.link_url + " target=\"_blank\">"+ el.link_url +"</a>"
                    }
                }
            ]' :data="term.links ?? []"></fx-table>
        </div>
    </div>
</template>

<script>
import PrimaryButton from "@jsAssets/Shared/Widgets/primary-button.vue";
import utils from "@jsAssets/utils"
import FxTable from "@jsAssets/Shared/Widgets/fx-table.vue";

export default {
    name: "TermDetails",
    components: {FxTable, PrimaryButton},
    props: {
        term: null
    },
    data () {
        return {
            links: []
        }
    },
    methods: {
        utils: function() {
            return utils
        }
    }
}
</script>

<style scoped>

</style>
