<script setup>
import MessagesHeader from "@/Chat/Messages/MessagesHeader.vue";
import {useChats} from "@/Chat/Composables/chats.js";
import {computed, nextTick, ref, shallowRef, watch} from "vue";
import defaultChat from "@/Chat/Composables/Defaults/chat.js";
import MessagesBody from "@/Chat/Messages/MessagesBody.vue";

const {prefetch} = defineProps({
    prefetch: Boolean,
})

const {initialLoadingCompleted, chats, selectedChat} = useChats();

const currentChatForMessagesBodyComponent = ref(defaultChat());
const messagesBodyComponents = shallowRef({});
const currentMessagesBodyComponent = computed(() =>
    messagesBodyComponents.value[currentChatForMessagesBodyComponent.value.id]);

if (prefetch) {
    const PREFETCH_MESSAGES_FOR_FIRST_CHATS_COUNT = 5;

    watch(initialLoadingCompleted, async () => {
        for (const chat of chats.value.slice(0, PREFETCH_MESSAGES_FOR_FIRST_CHATS_COUNT)) {
            currentChatForMessagesBodyComponent.value = chat;
            await nextTick(() => currentChatForMessagesBodyComponent.value = defaultChat());
        }
    })
}

watch(selectedChat, (selectedChat) => {
    currentChatForMessagesBodyComponent.value = selectedChat;
})

watch(currentChatForMessagesBodyComponent, (currentChat) => {
    if (!currentChat.id) return;
    messagesBodyComponents.value[currentChat.id] = MessagesBody;
});
</script>

<template>
    <div
        class="rounded-r-xl border border-gray-200 overflow-x-hidden"
        :class="{'bg-white overflow-y-hidden': !selectedChat.id}"
    >
        <div
            v-if="!selectedChat.id"
            class="h-full flex justify-center items-center"
        >
            <p class="text-2xl text-gray-400">
                Выберите чат
            </p>
        </div>
        <div
            class="h-full flex flex-col"
            :class="{'invisible': !selectedChat.id}"
        >
            <MessagesHeader :chat="selectedChat"/>
            <keep-alive :max="10">
                <component
                    :is="currentMessagesBodyComponent"
                    :key="currentChatForMessagesBodyComponent.id"
                    :chat="currentChatForMessagesBodyComponent"
                />
            </keep-alive>
        </div>
    </div>
</template>

<style scoped>

</style>
