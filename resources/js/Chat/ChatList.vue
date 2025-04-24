<script setup>
import ChatItem from "@/Chat/ChatItem.vue";

defineProps({
    chats: {
        type: Array,
        required: true,
    },
    currentChat: {
        type: Object,
        required: true,
    },
});

defineEmits({
    select: null,
});
</script>

<template>
    <div>
        <div
            v-for="chat in chats"
            class="m-2 h-18"
        >
            <ChatItem
                :chat="chat"
                :highlight="currentChat.id === chat.id"
                @click="$emit('select', chat)"
            />
        </div>
    </div>
</template>

<style scoped>

</style>
