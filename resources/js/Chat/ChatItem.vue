<script setup>
defineProps({
    chat: {
        type: Object,
        required: true,
    },
    highlight: Boolean,
    skeleton: Boolean
});
</script>

<template>
    <div
        class="relative rounded-xl cursor-pointer h-18 p-2 flex gap-3 items-center"
        :class="[
            highlight ? 'bg-gray-200' : 'hover:bg-gray-100',
            { 'animate-pulse hover:bg-inherit !cursor-default': skeleton }
        ]"
    >
        <div
            v-if="skeleton"
            class="w-[50px] h-[50px] rounded-full bg-gray-200 shrink-0"
        />
        <img
            v-else
            :src="chat.avatar_thumb"
            class="w-[50px] h-[50px] rounded-full shrink-0"
            alt="Аватар"
        />

        <div
            v-if="skeleton"
            class="h-4.5 bg-gray-200 rounded-full grow-1 max-w-56"
        />
        <div
            v-else
            class="flex flex-column"
        >
            <span class="text-gray-700">{{ chat.name }}</span>
        </div>

        <span v-if="skeleton" class="sr-only">Загрузка чатов...</span>
    </div>
</template>

<style scoped>

</style>
