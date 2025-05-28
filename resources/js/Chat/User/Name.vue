<script setup>
defineProps({
    name: {
        type: String,
        required: true
    }
});
</script>

<template>
    <span
        class="text-gray-700 text-base font-medium"
    >{{ name }}</span>
</template>

<style scoped>

</style>
