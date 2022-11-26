<template>
    <div v-show="status" class='font-medium text-sm text-green-600'>
        {{ status }}
    </div>
</template>

<script>
export default {
    name: "auth-session-status",
    props: {
        status: Array
    }
}
</script>

<style scoped>

</style>
