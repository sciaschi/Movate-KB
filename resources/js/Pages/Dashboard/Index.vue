<template>
    <div>
        <Head title="Dashboard" />
        <div class="row">
            <div class="py-12 col-6">
                <div class="max-w-7 mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white dark:bg-slate-800 border-b border-gray-200 dark:border-none">
                            <h2 class="header-text text-gray-800 font-semibold dark:text-slate-400 leading-tight dark:border-b-2 dark:border-indigo-600">
                                Recently Added Terms
                            </h2>
                        </div>
                        <RecentlyAddedTermsComponent></RecentlyAddedTermsComponent>
                    </div>
                </div>
            </div>
            <TrendingNewsComponent :canAddTrend="canAddTrend"></TrendingNewsComponent>
        </div>

    </div>

</template>

<script>
import { Head } from '@inertiajs/inertia-vue3'
import TrendingNewsComponent from "../../Shared/Components/TrendingNewsComponent";
import RecentlyAddedTermsComponent from "../../Shared/Components/RecentlyAddedTermsComponent";

export default {
    components: {
        Head,
        TrendingNewsComponent,
        RecentlyAddedTermsComponent
    },
    props: {
        canAddTrend: Boolean
    },
    mounted() {
        console.log('Component mounted.')
    },
    activated() {
        dashboard.init();
    }
}
</script>
