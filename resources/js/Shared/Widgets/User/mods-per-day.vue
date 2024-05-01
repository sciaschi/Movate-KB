<template>
    <component-layout header="Mods Per Day">
        <div id="mods-per-day">
            <span id="num-per-day" class="per-none">0</span>
        </div>
    </component-layout>
</template>

<script>
import ComponentLayout from "../../../Shared/Widgets/Shared/dashboard-component-layout.vue";
import route from "ziggy-js";
import { useCookies } from "vue3-cookies"
import moment from "moment";

export default {
    name: "mods-per-day",
    components: {
        ComponentLayout
    },
    methods: {
        getModsPerHour: async function() {
            console.log(this.$root.$refs.counter);

            if(this.cookies.get('page-count')) {
                let res = await axios.get(route('mods-per-hour'), {
                    moderations: this.cookies.get('page-count')
                })
                console.log(moment().hour());
            }
        }
    },
    setup () {
        const { cookies } = useCookies();
        return { cookies };
    },
    mounted() {
        this.getModsPerHour();
    },
    updated() {
        this.getModsPerHour();
    }
}
</script>

<style scoped>
    #mods-per-day {
        text-align: center;
    }
    #num-per-day {
        font-size: 50px;
        font-weight:bold;
    }
    .per-up {

    }
    .per-down {

    }
    .per-none {

        color: #9ca3af;
    }
</style>