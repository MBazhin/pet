<script setup>
import MessagesList from "@/Chat/Messages/MessagesList.vue";
import MessageInput from "@/Chat/Messages/MessageInput.vue";
import {ref} from "vue";
import {useMessages, addMessage} from "@/Chat/Composables/messages.js";
import {useMessage} from "@/Chat/Composables/message.js";

const {chat} = defineProps({
    chat: {
        type: Object,
        required: true,
    }
});

const {
    messages, loadMessagesForward, loadMessagesBackward, initialLoadingCompleted,
    canLoadMoreMessagesForward, canLoadMoreMessagesBackward
} = useMessages(chat);

const {makeMessage, storeMessage} = useMessage();

const input = ref('');

function handleMessageInputSubmit(messageInput) {
    messageInput.value.focus();

    if (!input.value) return;

    const sendingMessage = makeMessage(input.value);
    addMessage(chat, sendingMessage);
    storeMessage(sendingMessage, chat, {text: input.value});

    clearMessageInput();
}

function handleRetryStoreMessage(message) {
    storeMessage(message, chat, {text: message.text});
}

function clearMessageInput() {
    input.value = '';
}
</script>

<template>
    <!--flex-col-reverse для корректной последовательности tabindex-->
    <div class="h-full flex flex-col-reverse overflow-y-auto overflow-x-hidden">
        <MessageInput
            v-model="input"
            @submit="handleMessageInputSubmit"
        />
        <MessagesList
            :chat="chat"
            :messages="messages"
            :initialLoadingCompleted="initialLoadingCompleted"
            :canLoadMoreMessagesForward="canLoadMoreMessagesForward"
            :canLoadMoreMessagesBackward="canLoadMoreMessagesBackward"
            :loadMessagesForward="loadMessagesForward"
            :loadMessagesBackward="loadMessagesBackward"
            @retryStoreMessage="handleRetryStoreMessage"
        />
    </div>
</template>

<style scoped>

</style>
