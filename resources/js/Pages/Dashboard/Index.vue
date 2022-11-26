<template>
    <Head title="Dashboard" />
    <div class="row dark:bg-slate-900">
        <RecentlyAddedTermsComponent></RecentlyAddedTermsComponent>
        <TrendingNewsComponent :canAddTrend="canAddTrend"></TrendingNewsComponent>
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
    activated() {
        dashboard.init();
    }
}
</script>
