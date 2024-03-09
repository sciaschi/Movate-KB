<template>
    <div class="py-12 col-6">
        <div class="max-w-7 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-slate-800 dark:border-none">
                    <h2 class="header-text text-gray-800 font-semibold dark:text-slate-400 leading-tight dark:border-b-2 dark:border-indigo-600">
                        Trending News <button v-if="canAddTrend" @click="openAddTermModal()" id="add-trend-btn" class="action-btn"><i class="fa-solid fa-plus"></i></button>
                    </h2>
                </div>
                <div id="trends-container" class="container">
                    <div id="trends-grid" class="row">
                        <div class="col-md-6 col-sm-12 col-lg-4 col-xl-4 mb-3" v-for="trend in trends">
                            <a :href="trend.url" target="_blank" class="">
                                <div class="card dark:bg-slate-700 dark:text-slate-400" style="width: 12rem; margin-top:10px;">
                                    <img :src="trend.image" class="card-img-top trend-card" alt="Trend Image">
                                    <div class="card-body trend-card-body">
                                        <p class="card-text trend-card-text">
                                            {{trend.title}}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Swal from 'sweetalert2';
import route from "ziggy-js";

export default {
    name: "TrendingNewsComponent",
    props: {
        user: Object,
        canAddTrend: Boolean
    },
    data() {
       return {
           trends: null
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
            console.log(res);
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
