<script setup>
defineProps({
    chat: {
        type: Object,
        required: true,
    },
})
</script>

<template>
    <div class="p-2">
        <div
            v-if="!chat.id"
            class="flex h-full justify-center items-center"
        >
            <p class="text-2xl text-gray-400">
                Выберите чат
            </p>
        </div>
        <template v-else>
            {{ chat }}
        </template>
    </div>
</template>

<style scoped>

</style>
