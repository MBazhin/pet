<script setup>
defineProps({
    chat: {
        type: Object,
        required: true,
    },
    highlight: Boolean,
})
</script>

<template>
    <div
        class="p-2 h-full rounded-xl cursor-pointer flex gap-3 items-center"
        :class="highlight ? 'bg-gray-200' : 'hover:bg-gray-100'"
    >
        <img
            :src="chat.avatar_thumb"
            width="50"
            height="50"
            class="rounded-full"
            alt="Аватар"
        />

        <div class="flex flex-column">
            <span class="text-gray-700">{{ chat.name }}</span>
        </div>
    </div>
</template>

<style scoped>

</style>
