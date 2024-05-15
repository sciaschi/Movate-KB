<template>
    <header>
        <span class="header-text">Dashboard</span>
    </header>
    <div class="dashboard-container">
        <grid-layout
            :layout.sync="layout"
            :col-num="4"
            :row-height="185"
            :is-draggable="draggable"
            :is-resizable="false"
            :vertical-compact="true"
            :preventCollision="true"
            :use-css-transforms="false"
            :margin="[10,10]">
            <grid-item v-for="item in layout"
                       :ref="item.i"
                       :x="item.x"
                       :y="item.y"
                       :w="item.w"
                       :h="item.h"
                       :i="item.i">
                <component :is="item.c" v-bind="item.props"></component>
            </grid-item>
        </grid-layout>
    </div>
</template>


<script>
import TeamAccuracyGraph from "../../../Shared/Widgets/Admin/team-accuracy-graph";
import VueGridLayout, {GridLayout, GridItem} from 'vue-grid-layout-v3'

export default {
    name: "Index",
    components: {
        TeamAccuracyGraph,
        VueGridLayout,
        GridLayout,
        GridItem
    },
    data () {
        return {
            draggable: false,
            layout: [
                {"x":0,"y":0,"w":2,"h":2.5,"i":"tac", "c": 'team-accuracy-graph'},
            ]
        }
    },
    mounted() {

    }
}
</script>

<style scoped>

</style>
