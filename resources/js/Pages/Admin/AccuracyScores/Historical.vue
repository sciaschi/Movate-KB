<template>
    <header>
        <span class="header-text">{{headerText}}</span>
    </header>
    <AccuracyHistoryComponent/>
</template>

<script>
import AccuracyHistoryComponent from "../../../Shared/Components/AccuracyHistoryComponent";

export default {
    name: "Historical",
    props: {
      user:String
    },
    data () {
      return {
          headerText: 'Historical Accuracy Scores'
      }
    },
    components: {
        AccuracyHistoryComponent
    },
    mounted: function () {
        this.headerText = 'Historical Accuracy Scores - ' + this.$props.user
    }
}
</script>

<style scoped>

</style>
