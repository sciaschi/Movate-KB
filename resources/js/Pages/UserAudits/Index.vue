<template>
    <header>
        <span class="header-text">{{ 'Audits' }}</span>
    </header>
    <accuracy-history-component></accuracy-history-component>
</template>

<script>
import AccuracyHistoryComponent from "@jsAssets/Shared/Components/AccuracyHistoryComponent";
import FxTable from "@jsAssets/Shared/Widgets/fx-table.vue";

export default {
    name: "Index",
    data () {
      return {
      }
    },
    components: {
        FxTable,
        AccuracyHistoryComponent
    },
    methods: {

    },
    mounted: function () {
    }
}
</script>

<style scoped>

</style>
