<template>
    <Head title="Dashboard" />
    <header>
        <span class="header-text">Dashboard</span>
    </header>
    <div class="dark:bg-slate-900">
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
                       :i="item.i"
                       @move="moveEvent(item.i)">
                <component :is="item.c" v-bind="item.props"></component>
            </grid-item>
        </grid-layout>
    </div>
</template>
<script>
import { Head } from '@inertiajs/inertia-vue3'

import TrendingNewsComponent from "@jsAssets/Shared/Components/TrendingNewsComponent";
import RecentlyAddedTermsComponent from "@jsAssets/Shared/Components/RecentlyAddedTermsComponent";
import ModsPerHour from "@jsAssets/Shared/Widgets/User/mods-per-hour.vue";
import VueGridLayout, {GridLayout, GridItem} from 'vue-grid-layout-v3'
import ModsPerDay from "@jsAssets/Shared/Widgets/User/mods-per-day.vue";

export default {
    components: {
        Head,
        VueGridLayout,
        GridItem,
        GridLayout,
        TrendingNewsComponent,
        RecentlyAddedTermsComponent,
        ModsPerHour,
        ModsPerDay
    },
    props: {
        canAddTrend: Boolean
    },
    data () {
        return {
            draggable: false,
            layout: [
                {"x":0,"y":0,"w":1,"h":1,"i":"mph", "c": 'ModsPerHour'},
                {"x":1,"y":0,"w":1,"h":1,"i":"mpd", "c": 'ModsPerDay'},
                // {"x":2,"y":0,"w":1,"h":1,"i":"2", "c": 'ModsPerHour'},
                // {"x":3,"y":0,"w":1,"h":1,"i":"3", "c": 'ModsPerHour'},
                {"x":0,"y":1,"w":2,"h":3.2,"i":"tnc", "c": 'TrendingNewsComponent', "props": {canAddTrend: this.canAddTrend}}, // component name used but you could also use a reference to the component
                {"x":2,"y":1,"w":2,"h":4,"i":"ratc", "c": 'RecentlyAddedTermsComponent'}
            ]
        }
    },
    methods: {
        moveEvent: function (i, newX, newY) {
            var p;
            for (p = 0; p < this.layout.length; p++) {
                //Horizontal swapping
                if (
                    newX >= this.layout[p]["x"] &&
                    newX < this.layout[p]["x"] + this.layout[p]["w"] &&
                    this.layout[i]["y"] == this.layout[p]["y"] &&
                    i != this.layout[p]["i"]
                ) {
                    let initialX = this.layout[i]["x"];
                    let finalX = this.layout[p]["x"];
                    this.layout[i]["x"] = finalX;
                    this.layout[p]["x"] = initialX;
                }
                //Vertical swapping
                if (
                    newY >= this.layout[p]["y"] &&
                    newY < this.layout[p]["y"] + 1 &&
                    this.layout[i]["x"] == this.layout[p]["x"] &&
                    i != this.layout[p]["i"]
                ) {
                    let initialY = this.layout[i]["y"];
                    let finalY = this.layout[p]["y"];
                    this.layout[i]["y"] = finalY;
                    this.layout[p]["y"] = initialY;
                }
            }
        },
    }
}
</script>
