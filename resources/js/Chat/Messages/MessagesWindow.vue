<script setup>
import MessagesHeader from "@/Chat/Messages/MessagesHeader.vue";
import MessageInput from "@/Chat/Messages/MessageInput.vue";
import MessagesList from "@/Chat/Messages/MessagesList.vue";
import {useChats} from "@/Chat/Composables/chats.js";
import {computed, nextTick, ref, shallowRef, watch} from "vue";
import defaultChat from "@/Chat/Composables/Defaults/chat.js";

const {prefetch} = defineProps({
    prefetch: Boolean,
})

const {initialLoadingCompleted, chats, selectedChat} = useChats();

const currentChatForChatMessagesComponent = ref(defaultChat());
const chatMessagesComponents = shallowRef({});
const currentChatMessagesComponent = computed(() =>
    chatMessagesComponents.value[currentChatForChatMessagesComponent.value.id]);

if (prefetch) {
    const PREFETCH_MESSAGES_FOR_FIRST_CHATS_COUNT = 5;

    watch(initialLoadingCompleted, async () => {
        for (const chat of chats.value.slice(0, PREFETCH_MESSAGES_FOR_FIRST_CHATS_COUNT)) {
            currentChatForChatMessagesComponent.value = chat;
            await nextTick(() => currentChatForChatMessagesComponent.value = defaultChat());
        }
    })
}

watch(selectedChat, (selectedChat) => {
    currentChatForChatMessagesComponent.value = selectedChat;
})

watch(currentChatForChatMessagesComponent, (currentChat) => {
    if (!currentChat.id) return;
    chatMessagesComponents.value[currentChat.id] = MessagesList;
});
</script>

<template>
    <div
        class="bg-white rounded-r-xl border border-gray-200 overflow-y-auto overflow-x-hidden"
        :class="{'overflow-y-hidden': !selectedChat.id}"
    >
        <div
            v-show="!selectedChat.id"
            class="h-full flex justify-center items-center"
        >
            <p class="text-2xl text-gray-400">
                Выберите чат
            </p>
        </div>
        <div class="h-full flex flex-col">
            <MessagesHeader :chat="selectedChat"/>
            <keep-alive :max="10">
                <component
                    :is="currentChatMessagesComponent"
                    :key="currentChatForChatMessagesComponent.id"
                    :chat="currentChatForChatMessagesComponent"
                />
            </keep-alive>
            <MessageInput/>
        </div>
    </div>
</template>

<style scoped>

</style>
