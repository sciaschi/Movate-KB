<template>
    <admin-navigation />

    <div class="admin-layout-container pt-4 pr-4 text-white of-y-scroll">
        <slot />
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'
import DropdownLink from "./../Widgets/dropdown-link";
import Dropdown from "./../Widgets/dropdown";
import {computed} from "vue";
import { usePage } from '@inertiajs/inertia-vue3';
import AdminNavigation from "./AdminNavigation";

export default {
    components: {
        AdminNavigation,
        Dropdown,
        DropdownLink,
        Link
    },
    setup() {
        const user = computed(() => usePage().props.value.auth.user)
        return { user }
    },
    mounted() {
        this.$el.parentElement.classList = 'bg-gray-100 dark:bg-slate-900 overflow-y-hidden';
    }
}
</script>

<style>
.admin-layout-container {
    height:100vh;
    margin-left: 330px;
    max-width: calc(100% - 330px);
}
</style>