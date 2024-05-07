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
                       :static="false"
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
        <div v-if="loading" class="overlay">
            <span class="lds-dual-ring"></span>
        </div>
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
           loading: false,
           layout: []
       }
    },
    methods: {
        getTrends: async function() {
            this.loading = true;

            let res = await axios.get(route('get_trends'), {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            this.layout = [];
            this.trends = res.data.trends ?? [];

            for(let i = 0; i < this.trends.length; i++) {
                this.layout.push({
                    x: this.layout.length % 3,
                    y: this.layout.length * 2, // puts it at the bottom
                    w: 1,
                    h: 2,
                    i: 'trend-'+ i
                });
            }
            console.log(this.layout);
            this.loading = false;
        },
        openAddTermModal: function() {
            Swal.fire({
                title: 'Add Trending News Article',
                html: '<input type="text" id="url-val" class="form-control" placeholder="Enter Web address..." aria-label="Enter Web address...">',
                focusConfirm: false,
                confirmButtonText: 'Save',
                showCancelButton: true,
                width: 1000,
                preConfirm: () => {
                    var inputData = {
                        url: document.getElementById('url-val').value.toString(),
                    };
                    let savingToast = this.$toast.info('Saving Trend - Please Wait...', {
                        duration: 0
                    });

                    axios.post(route('add_trend'), inputData, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    }).then((data) => {
                        savingToast.dismiss();

                        if(data.status)
                        {
                            this.$toast.success('Trend Saved!', {
                                duration: 5000
                            });
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
    beforeMount: async function() {
        await this.getTrends();

        var channel = Echo.channel('TrendsUpdated');

        channel.listen('TrendsUpdatedEvent', (e) => {
            this.layout = [];
            this.trends = e.trends;

            for(let i = 0; i < this.trends.length; i++) {
                this.layout.push({
                    x: this.layout.length % 3,
                    y: this.layout.length * 3, // puts it at the bottom
                    w: 1,
                    h: 2,
                    i: 'trend-'+ i
                });
            }
        })

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
