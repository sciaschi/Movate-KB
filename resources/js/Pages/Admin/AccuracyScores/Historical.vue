<template>
    <header>
        <span class="header-text">{{ 'Historical Accuracy Scores - ' + this.$props.user}}</span>
    </header>
    <accuracy-history-component></accuracy-history-component>
</template>

<script>
import AccuracyHistoryComponent from "@jsAssets/Shared/Components/AccuracyHistoryComponent";
import FxTable from "@jsAssets/Shared/Widgets/fx-table.vue";

export default {
    name: "Historical",
    props: {
      user:String
    },
    data () {
      return {
          columns: [],
          data: []
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
