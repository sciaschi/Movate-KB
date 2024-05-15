<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap pb-1">
            <template v-for="(link, key) in links">
                <div v-if="link.url === null" :key="key" class="mb-1 mr-1 px-4 py-3 text-gray-200 text-sm leading-4 border border-indigo-500 rounded" v-html="link.label" />
                <button v-else :key="`link-${key}`" class="mb-1 mr-1 px-4 py-3 text-gray-50 focus:text-white-500 text-sm leading-4 hover:bg-indigo-500 border border-indigo-800 focus:border-indigo-500 rounded" :class="{ 'bg-indigo-500': link.active, 'bg-indigo-900': !link.active }" @click="this.runAjax(link.url)" v-html="link.label" />
            </template>
        </div>
    </div>
</template>

<script>

import {Link} from "@inertiajs/inertia-vue3";

export default {
    name: 'pagaination',
    components: {
        Link,
    },
    props: {
        links: Array,
    },
    emits:['data'],
    methods: {
        runAjax: function(url) {
            axios.get(url).then((e) => {
                this.$emit('data', e.data.data);
            })
        }
    }
}
</script>

<style scoped>
.table>:not(caption)>*>* {
    border-bottom-width: 0;
}
</style>
