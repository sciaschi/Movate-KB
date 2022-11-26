<template>
    <label class='block font-medium text-sm text-gray-700'>
        {{ value }}
    </label>
</template>

<script>
export default {
    name: "input-label",
    props: {
        value: String
    }
}
</script>

<style scoped>

</style>
