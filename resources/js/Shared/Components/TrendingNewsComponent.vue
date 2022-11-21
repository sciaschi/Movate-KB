<template>
    <div class="col-6 mx-auto sm:px-6 lg:px-8 mb-3">
        <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200 dark:bg-slate-800">
                <h2 class="header-text font-semibold dark:text-slate-400 leading-tight dark:border-b-2 dark:border-indigo-600">
                    Trending News <button v-if="canAddTrend" @click="openAddTermModal()" id="add-trend-btn" type="button" class="btn btn-outline-primary"><i class="fa-solid fa-plus"></i></button>
                </h2>
                <div class="container">
                    <div id="trends-grid" class="row align-items-stretch">
                        <div class="col-md-6 col-sm-12 col-lg-4 col-xl-4 d-flex align-items-stretch pb-2" v-for="trend in trends">
                            <a :href="trend.url" target="_blank" class="d-flex align-items-stretch">
                                <div class="card h-100 dark:bg-slate-700 dark:text-slate-400" style="width: 23rem; margin-top:10px;">
                                    <img :src="trend.image" class="card-img-top" alt="Trend Image">
                                    <div class="card-body">
                                        <p class="card-text">{{trend.title}}</p>
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
