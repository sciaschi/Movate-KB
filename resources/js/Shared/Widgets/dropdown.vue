<template>
    <div class="relative">
        <div @click="open = !open">
            <slot name="trigger">
            </slot>
        </div>

        <div v-show="open"
             :class="width"
             class="absolute z-50 mt-2 rounded-md shadow-lg"
             style="display: none;"
             @mouseleave="open = false"
             @click="open = false">
            <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white">
                <slot name="content">
                </slot>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "dropdown",
    data () {
        return {
            open: false,
            width: 'w-48'
        }
    }
}
</script>

<style scoped>

</style>
