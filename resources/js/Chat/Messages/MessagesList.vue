<script setup>
import {useMessages} from "@/Chat/Composables/messages.js";
import {computed, onActivated, onMounted, onUpdated} from "vue";
import MessageItem from "@/Chat/Messages/MessageItem.vue";
import {useInfiniteScroll} from "@/Chat/Composables/infiniteScroll.js";
import {templateRef, useScroll} from "@vueuse/core";
import {useAuth} from "@/Chat/Composables/auth.js";

const offset = 375;
const messageContainer = templateRef('messageContainer');

const {user} = useAuth();
const {chat} = defineProps({
    chat: {
        type: Object,
        required: true,
    },
})
const keyedChatUsers = computed(() => chat.users.reduce((acc, user) => {
    acc[user.id] = user;
    return acc;
}, {[user.value.id]: user.value}));

const {
    messages, canLoadMoreMessagesForward, canLoadMoreMessagesBackward, loadMessagesForward, loadMessagesBackward
} = useMessages(chat.id);

const {y} = useScroll(messageContainer);

useInfiniteScroll(messageContainer, {directions: {
    top: {
        canLoadMore: () => canLoadMoreMessagesForward.value,
        onLoadMore: loadMessagesForward,
    },
    bottom: {
        canLoadMore: () => canLoadMoreMessagesBackward.value,
        onLoadMore: loadMessagesBackward,
    },
}, directionType: 'reversed', interval: 1000, offset: {top: offset, bottom: offset}});

onMounted(() => {
    loadMessagesForward();
})

onActivated(() => {
    messageContainer.value.scrollTop = y.value;
})

onUpdated(() => {
    console.log(chat);
})
</script>

<template>
    <div
        ref="messageContainer"
        class="h-full flex flex-col-reverse overflow-y-auto py-1.5 pr-2"
    >
        <MessageItem
            v-for="(message, index) in messages"
            :message="message"
            :user="keyedChatUsers[message.sender_id]"
            :is-last-sender-message="message.sender_id !== messages[index + 1]?.sender_id"
        />
    </div>
</template>

<style scoped>

</style>
