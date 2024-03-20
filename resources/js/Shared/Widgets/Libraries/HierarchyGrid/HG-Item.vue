<script>
export default {
    name: "hg-item",
    props: {
        col: {
            type: Number,
            default: 1
        },
        item: {
            type: Object,
            default: () => ({})
        }
    },
    data() {
        return {
        }
    },
    methods: {
    },
    mounted() {
    }
}
</script>

<template v-slot:`column-${col}`>
    <div ref="itemRef"
         class="hg-item">
        <slot ref="domRef"></slot>
    </div>
</template>

<style scoped>

</style>