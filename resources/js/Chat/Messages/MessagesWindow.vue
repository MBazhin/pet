<script setup>
import MessagesHeader from "@/Chat/Messages/MessagesHeader.vue";
import MessageInput from "@/Chat/Messages/MessageInput.vue";
import MessagesList from "@/Chat/Messages/MessagesList.vue";
import {useChats} from "@/Chat/Composables/chats.js";
import {shallowRef, watchEffect} from "vue";

const {selectedChat: chat} = useChats();
const chatMessagesComponents = shallowRef({});

watchEffect(() => {
    if (!chat.value.id) return;
    chatMessagesComponents.value[chat.value.id] = MessagesList;
})
</script>

<template>
    <div
        class="bg-white rounded-r-xl border border-gray-200 overflow-y-auto overflow-x-hidden"
        :class="{'overflow-y-hidden': !chat.id}"
    >
        <div
            v-show="!chat.id"
            class="h-full flex justify-center items-center"
        >
            <p class="text-2xl text-gray-400">
                Выберите чат
            </p>
        </div>
        <div class="h-full flex flex-col">
            <MessagesHeader :chat="chat"/>
            <keep-alive :max="10">
                <component
                    :is="chatMessagesComponents[chat.id]"
                    :key="chat.id"
                    :chat="chat"
                />
            </keep-alive>
            <MessageInput/>
        </div>
    </div>
</template>

<style scoped>

</style>
