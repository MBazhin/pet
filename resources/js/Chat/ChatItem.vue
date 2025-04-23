<script setup>
defineProps({
    chat: {
        type: Object,
        required: true,
    },
})
</script>

<template>
    <div class="p-2 h-full hover:bg-gray-100 rounded-xl cursor-pointer">
        {{ chat }}
    </div>
</template>

<style scoped>

</style>
