<script setup>
defineProps({
    src: String,
    alt: {
        type: String,
        required: true,
    }
});
</script>

<template>
    <img
        :src="src"
        class="w-[50px] h-[50px] rounded-full shrink-0"
        :alt="alt"
    />
</template>

<style scoped>

</style>
