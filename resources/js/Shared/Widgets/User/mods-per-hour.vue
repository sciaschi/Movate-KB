<template>
    <component-layout header="Mods Per Hour">
        <div id="mods-per-hour">
            <span id="num-per-hr" class="per-none">
                {{ modsPerHour > 0 ? modsPerHour : 0 }}
<!--                <i class="fa-solid" :class="this.icon"></i>-->
            </span>
        </div>
    </component-layout>
</template>

<script>
import ComponentLayout from "../../../Shared/Widgets/Shared/dashboard-component-layout.vue";
import { useCookies } from "vue3-cookies"
import moment from "moment";

export default {
    name: "mods-per-hour",
    components: {
        ComponentLayout
    },
    data() {
        return {
            icon: null,
            pollingLoop: null,
            modsPerHour: 0
        }
    },
    methods: {
        getModsPerHour: function() {
            let hoursWorked = moment(this.cookies.get('cur-time')).diff(this.cookies.get('start-time'), 'hours') - 1,
                modsPerHour = this.cookies.get('page-count') * 12 / hoursWorked;

            if(hoursWorked > 0 && hoursWorked <= 8) {
                if(modsPerHour > this.modsPerHour) {
                    this.icon = 'fa-caret-up text-green-800'
                } else if(modsPerHour < this.modsPerHour) {
                    this.icon = 'fa-caret-down text-red-800'
                } else {
                    this.icon = 'fa-minus'
                }

                this.modsPerHour = modsPerHour.toFixed(2);
            } else {
                this.modsPerHour = 0
            }

            this.cookies.set('cur-time', moment().utc().format())
        }
    },
    setup () {
        const { cookies } = useCookies();
        return { cookies };
    },
    mounted() {
        this.pollingLoop = setInterval(this.getModsPerHour, 10000);
        let hoursWorked = moment(this.cookies.get('cur-time')).diff(this.cookies.get('start-time'), 'hours') - 1;

        if(hoursWorked > 0 && hoursWorked <= 8) {
            let modsCount   = this.cookies.get('page-count') * 12;

            this.modsPerHour = (modsCount / hoursWorked).toFixed(2)
        } else {
            this.modsPerHour = 0
        }
    },
    beforeUnmount() {
        clearInterval(this.pollingLoop);
    }
}
</script>

<style scoped>
    #mods-per-hour {
        text-align: center;
    }
    #num-per-hr {
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