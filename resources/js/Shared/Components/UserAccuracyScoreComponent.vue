<template>
    <dashboard-component-layout header="Latest Accuracy">
        <div id="acc-perc">
            <span id="acc-perc-text" class="per-none" v-html="accuracy"></span>
        </div>
    </dashboard-component-layout>
</template>

<script>
import DashboardComponentLayout from "../Widgets/Shared/dashboard-component-layout.vue";
import route from "ziggy-js/src/js";

export default {
    name: "UserAccuracyScoreComponent",
    components: {
        DashboardComponentLayout
    },
    data () {
        return {
            accuracy: 'N/A'
        }
    },
    methods: {
        getData: function () {
            axios.get(route('get-user-accuracy', {
                id:  this.$page.props.auth.user.id
            })).then((e) => {
                console.log(e);
                this.accuracy = e.data.accuracy
            })
        }
    },
    mounted() {
        this.getData();
    }
}
</script>

<style scoped>
#acc-perc {
    text-align: center;
}
#acc-perc-text {
    font-size: 50px;
    font-weight:bold;
}
.per-none {
    color: #9ca3af;
}
</style>
