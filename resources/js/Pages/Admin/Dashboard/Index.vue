<template>
    <header>
        <span class="header-text">Dashboard</span>
    </header>
    <div class="container">
        <div class="grid-stack">
            <div class="grid-stack-item bg-gray-800 px-3 rounded-md" gs-w="5" gs-h="4">
                <team-accuracy-graph></team-accuracy-graph>
            </div>
        </div>
    </div>
</template>


<script>
import Chart from 'chart.js/auto';
import TeamAccuracyGraph from "../../../Shared/Widgets/Admin/team-accuracy-graph";

export default {
    name: "Index",
    components: {TeamAccuracyGraph},
    mounted() {

    }
}
</script>

<style scoped>

</style>
