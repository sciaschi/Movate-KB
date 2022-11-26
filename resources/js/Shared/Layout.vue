<template>
    <navigation />
    <div class="container">
        <slot />
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'
import DropdownLink from "./Widgets/dropdown-link";
import Dropdown from "./Widgets/dropdown";
import {computed} from "vue";
import { usePage } from '@inertiajs/inertia-vue3';
import Navigation from "./Navigation";

export default {
    components: {
        Navigation,
        Dropdown,
        DropdownLink,
        Link
    },
    setup() {
        const user = computed(() => usePage().props.value.auth.user)
        return { user }
    },
    mounted() {
        this.$el.parentElement.classList = 'bg-gray-100 dark:bg-slate-900';
    }
}
</script>
