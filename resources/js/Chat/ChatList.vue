<script setup>
import ChatItem from "@/Chat/ChatItem.vue";

defineProps({
    chats: {
        type: Array,
        required: true,
    },
})
</script>

<template>
    <div>
        <div
            v-for="chat in chats"
            class="px-2 first:pt-2 last:pb-2 h-18"
        >
            <ChatItem
                :chat="chat"
            />
        </div>
    </div>
</template>

<style scoped>

</style>
