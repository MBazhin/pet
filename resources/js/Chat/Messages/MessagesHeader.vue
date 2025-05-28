<script setup>
const {chat} = defineProps({
    chat: {
        type: Object,
        required: true,
    },
})
</script>

<template>
    <div class="bg-white shadow-lg h-20 rounded-r-lg w-full p-2 overflow-hidden">
        {{ chat }}
    </div>
</template>

<style scoped>

</style>
