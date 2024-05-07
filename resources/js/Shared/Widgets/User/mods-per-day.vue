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
    data() {
        return {
            icon: null,
            pollingLoop: null,
            modsPerDay: 0
        }
    },
    methods: {
        getModsPerDay: function() {
            if(this.cookies.get('cur-time') >= this.cookies.get('start-time')) {
                let modsPerDay  = this.cookies.get('page-count') * 12 / 8;

                if(modsPerDay > this.modsPerDay) {
                    this.icon = 'fa-caret-up text-green-800'
                } else if(modsPerDay < this.modsPerDay) {
                    this.icon = 'fa-caret-down text-red-800'
                } else {
                    this.icon = 'fa-minus'
                }

                this.modsPerDay = modsPerDay
            } else {
                this.modsPerDay = 0
            }

            this.cookies.set('cur-time', moment().utc().format())
        }
    },
    setup () {
        const { cookies } = useCookies();
        return { cookies };
    },
    mounted() {
        this.pollingLoop = setInterval(this.getModsPerDay, 10000);

        let modsCount   = this.cookies.get('page-count') * 12;

        if(moment().utc().hour() >= this.cookies.get('start-time')) {
            this.modsPerDay = modsCount / 8
        } else {
            this.modsPerDay = 0
        }
    },
    beforeUnmount() {
        clearInterval(this.pollingLoop);
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