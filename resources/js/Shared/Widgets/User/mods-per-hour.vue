<template>
    <component-layout header="Mods Per Hour">
        <div id="mods-per-hour">
            <span id="num-per-hr" class="per-none">0</span>
        </div>
    </component-layout>
</template>

<script>
import ComponentLayout from "../../../Shared/Widgets/Shared/dashboard-component-layout.vue";

export default {
    name: "mods-per-hour",
    components: {
        ComponentLayout
    },
    methods: {
        getModsPerHour: async function() {

        }
    },
    mounted() {

    },
    updated() {

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