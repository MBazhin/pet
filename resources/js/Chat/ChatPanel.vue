<script setup>
import { ref } from 'vue';
import { useDefaults } from "@/Chat/Composables/defaults.js";
import ChatList from "@/Chat/ChatList.vue";
import MessagesWindow from "@/Chat/MessagesWindow.vue";

const { chat: defaultChat } = useDefaults();

const chats = ref([]);
const currentChat = ref(defaultChat());

loadChatList();

function loadChatList() {
    axios.get('/api/chat')
        .then(({ data }) => {
            chats.value = data;
        });
}

function selectChat(chat) {
    currentChat.value = currentChat.value.id === chat.id
        ? defaultChat()
        : chat;
}
</script>

<template>
    <div class="grid grid-cols-12 gap-3 h-full p-3">
        <ChatList
            class="col-span-4 bg-white rounded-l-xl border border-gray-200 overflow-y-auto"
            :chats="chats"
            :current-chat="currentChat"
            @select="selectChat"
        />
        <MessagesWindow
            class="col-span-8 bg-white rounded-r-xl border border-gray-200"
            :chat="currentChat"
        />
    </div>
</template>

<style scoped>

</style>
