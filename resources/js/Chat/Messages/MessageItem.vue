<script setup>
const {message} = defineProps({
    message: {
        type: Object,
        required: true
    },
    user: {
        type: Object,
        required: true
    },
});
</script>

<template>
    <div class="p-2 border-gray-300 flex gap-4">
        <img
            :src="user.avatar_thumb"
            class="w-[50px] h-[50px] rounded-full shrink-0"
            :alt="user.name"
        />
        {{ message.text }}
    </div>
</template>

<style scoped>

</style>
