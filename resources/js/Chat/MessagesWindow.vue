<script setup>
import {useChats} from "@/Chat/Composables/chats.js";

const {selectedChat: chat} = useChats();
</script>

<template>
    <div class="p-2 bg-white rounded-r-xl border border-gray-200 overflow-y-auto overflow-x-hidden">
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
