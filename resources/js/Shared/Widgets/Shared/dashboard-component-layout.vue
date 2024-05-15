<script>

export default {
    name: "dashboard-component-layout",
    props: {
        id: '',
        header: '',
        isLoading: false
    },
    methods: {

    }
}
</script>

<template>
    <div :id="id" class="max-height bg-white dark:bg-slate-800 overflow-hidden shadow-lg sm:rounded-lg">
        <div class="p-4 bg-white dark:bg-slate-800 dark:border-none">
            <h2 class="header-text text-gray-800 font-semibold dark:text-slate-400 leading-tight dark:border-b-2 dark:border-indigo-600">
                {{ header }} <slot name="header-actions"></slot>
            </h2>
        </div>
        <div class="component-container">
            <slot></slot>
        </div>
    </div>
</template>

<style scoped>
</style>
