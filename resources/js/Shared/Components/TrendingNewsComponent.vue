<template>
    <component-layout header="Trending News">
        <template #header-actions>
            <button v-if="canAddTrend" @click="openAddTermModal()" id="add-trend-btn" class="action-btn"><i class="fa-solid fa-plus"></i></button>
        </template>
        <grid-layout
            v-if="trends"
            :layout.sync="layout"
            :col-num="3"
            :row-height="120"
            :is-draggable="false"
            :is-resizable="false"
            :vertical-compact="true"
            :preventCollision="true"
            :auto-size="true"
            :use-css-transforms="false"
            :margin="[5,5]">
            <grid-item v-for="(item, index) in layout"
                       :static="true"
                       :ref="item.i"
                       :x="item.x"
                       :y="item.y"
                       :w="item.w"
                       :h="item.h"
                       :i="item.i"
                        style="text-align: center">
                <a :href="trends[index].url" target="_blank">
                    <div class="card max-height dark:bg-slate-700 dark:text-slate-400">
                        <img :src="trends[index].image" class="card-img-top trend-card" alt="Trend Image">
                        <div class="card-body trend-card-body">
                            <p class="card-text trend-card-text">
                                {{trends[index].title}}
                            </p>
                        </div>
                    </div>
                </a>
            </grid-item>
        </grid-layout>
    </component-layout>

</template>

<script>
import Swal from 'sweetalert2';
import route from "ziggy-js";
import ComponentLayout from "@jsAssets/Shared/Widgets/Shared/dashboard-component-layout.vue";
import VueGridLayout, {GridLayout, GridItem} from 'vue-grid-layout-v3'

export default {
    name: "TrendingNewsComponent",
    components: {
        ComponentLayout,
        GridLayout,
        GridItem
    },
    props: {
        user: Object,
        canAddTrend: Boolean
    },
    data() {
       return {
           trends: null,
           layout: [
               {"x":0,"y":0,"w":1,"h":2,"i":"trend-1"},
               {"x":1,"y":0,"w":1,"h":2,"i":"trend-2"},
               // {"x":2,"y":0,"w":1,"h":2,"i":"trend-3"},
               // {"x":0,"y":1,"w":1,"h":2,"i":"trend-4"},
               // {"x":1,"y":1,"w":1,"h":2,"i":"trend-5"},
               // {"x":2,"y":1,"w":1,"h":2,"i":"trend-6"},
           ]
       }
    },
    methods: {
        pollData () {
            this.polling = setInterval(async () => {
                await this.getTrends();
            }, 60000)
        },
        getTrends: async function() {
            let res = await axios.get(route('get_trends'), {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            this.trends = res.data.trends;
        },
        openAddTermModal: function() {
            Swal.fire({
                title: 'Add Trending News Article',
                html:
                    '<input type="text" id="url-val" class="form-control" placeholder="Enter Web address..." aria-label="Enter Web address...">',
                focusConfirm: false,
                confirmButtonText: 'Save',
                showCancelButton: true,
                width: 1000,
                preConfirm: () => {
                    var inputData = {
                        url: document.getElementById('url-val').value.toString(),
                    };

                    axios.post(route('add_trend'), inputData, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    }).then((data) => {
                        if(data.status)
                        {
                            Swal.fire('Saved!', '', 'success')
                            this.getTrends();
                        }
                        return false
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: "Failed",
                            text: `${error.message}`
                        })
                    });
                }
            });
        }
    },
    mounted: async function() {
        await this.getTrends();
        this.pollData();
    },
    unmounted: function () {
        this.polling = null;
    }
}
</script>

<style scoped>
#add-trend-btn {
    font-size: 14px;
}
::placeholder {
    color: red;
    opacity: 1; /* Firefox */
}
</style>
