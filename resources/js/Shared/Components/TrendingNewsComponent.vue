<template>
    <div class="py-12 col-6">
        <div class="max-w-7 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-slate-800 dark:border-none">
                    <h2 class="header-text text-gray-800 font-semibold dark:text-slate-400 leading-tight dark:border-b-2 dark:border-indigo-600">
                        Trending News <button v-if="canAddTrend" @click="openAddTermModal()" id="add-trend-btn" type="button" class="btn btn-outline-primary"><i class="fa-solid fa-plus"></i></button>
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
            this.polling = setInterval(() => {
                this.getTrends();
            }, 60000)
        },
        getTrends: function() {
            var context = this;

            $.ajax({
                async: true,
                method: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/trend/get-trends",
                data: {
                    'count': 4
                }
            })
            .done(function( data ) {
                context.trends = data['trends'];
            });
        },
        openAddTermModal: function() {
            const context = this;

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

                    $.ajax({
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "/trend/store",
                        data: inputData
                    }).done(function( data ) {
                        if(data.status)
                        {
                            Swal.fire('Saved!', '', 'success')
                            context.getTrends();
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
    created: function() {
        this.pollData();
    },
    mounted: function() {
        this.getTrends();
    }
}
</script>

<style scoped>

</style>
