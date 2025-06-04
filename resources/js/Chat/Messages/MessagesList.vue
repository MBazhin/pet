<script setup>
import {computed, onActivated, onMounted, onUpdated} from "vue";
import MessageItem from "@/Chat/Messages/MessageItem.vue";
import {useInfiniteScroll} from "@/Chat/Composables/infiniteScroll.js";
import {templateRef, useScroll} from "@vueuse/core";
import {useAuth} from "@/Chat/Composables/auth.js";

const offset = 375;
const messageContainer = templateRef('messageContainer');

const {user} = useAuth();
const keyedChatUsers = computed(() => chat.users.reduce((acc, user) => {
    acc[user.id] = user;
    return acc;
}, {[user.value.id]: user.value}));

const {
    chat, messages, initialLoadingCompleted, canLoadMoreMessagesForward,
    canLoadMoreMessagesBackward, loadMessagesForward, loadMessagesBackward
} = defineProps({
    chat: {
        type: Object,
        required: true,
    },
    messages: {
        type: Array,
        required: true,
    },
    initialLoadingCompleted: {
        type: Boolean,
        required: true,
    },
    canLoadMoreMessagesForward: {
        type: Boolean,
        required: true,
    },
    canLoadMoreMessagesBackward: {
        type: Boolean,
        required: true,
    },
    loadMessagesForward: {
        type: Function,
        required: true,
    },
    loadMessagesBackward: {
        type: Function,
        required: true,
    },
});

defineEmits({
    retryStoreMessage: null
});

//todo вынести на уровень MessageBody
const messagesAfterInitial = computed(() => initialLoadingCompleted ? messages : []);

const {y} = useScroll(messageContainer);

useInfiniteScroll(messageContainer, {directions: {
    top: {
        canLoadMore: () => canLoadMoreMessagesForward,
        onLoadMore: loadMessagesForward,
    },
    bottom: {
        canLoadMore: () => canLoadMoreMessagesBackward,
        onLoadMore: loadMessagesBackward,
    },
}, directionType: 'reversed', interval: 1000, offset: {top: offset, bottom: offset}});

onMounted(() => {
    if (!initialLoadingCompleted) loadMessagesForward();
})

onActivated(() => {
    messageContainer.value.scrollTop = y.value;
})

onUpdated(() => {
    //todo убрать
    console.log(chat);
})
</script>

<template>
    <div
        ref="messageContainer"
        class="h-full flex flex-col-reverse overflow-y-auto py-1.5 pr-2"
    >
        <MessageItem
            v-for="(message, index) in messagesAfterInitial"
            :message="message"
            :user="keyedChatUsers[message.sender_id]"
            :is-last-sender-message="message.sender_id !== messages[index + 1]?.sender_id"
            @retryStore="$emit('retryStoreMessage', message)"
        />
    </div>
</template>

<style scoped>

</style>
