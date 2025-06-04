<script setup>
import ChatItem from "@/Chat/ChatItem.vue";
import {vInfiniteScroll} from "@/Chat/Composables/infiniteScroll.js";
import {useChats} from "@/Chat/Composables/chats.js";
import {computed, onMounted} from "vue";
import {useChatsLastMessages} from "@/Chat/Composables/messages.js";

const {
    chats, selectedChat, initialLoadingCompleted, canLoadMoreChats, isChatsLoading, loadChats, selectChat
} = useChats();

const {chatsLastMessages} = useChatsLastMessages();

const sortedChatsByLastMessage = computed(() => {
    return chats.value.toSorted((c1, c2) => {
        const lastMessage1 = chatsLastMessages.value.get(c1.id);
        const lastMessage2 = chatsLastMessages.value.get(c2.id);

        return new Date(lastMessage2?.created_at).getTime() - new Date(lastMessage1?.created_at).getTime();
    });
});

onMounted(loadChats);
</script>

<template>
    <div
        class="bg-white rounded-l-xl
               border border-gray-200
               overflow-y-auto overflow-x-hidden
               flex flex-col gap-2 p-2"
        :class="{'overflow-y-hidden': !initialLoadingCompleted}"
        v-infinite-scroll="{
            canLoadMore: () => canLoadMoreChats, onLoadMore: loadChats, interval: 2000, offset: {bottom: 100}
        }"
    >
        <template v-if="initialLoadingCompleted">
            <TransitionGroup>
                <ChatItem
                    v-for="(chat, index) in sortedChatsByLastMessage"
                    class="shrink-0"
                    :key="index"
                    :chat="chat"
                    :highlight="selectedChat.id === chat.id"
                    @click="selectChat(chat)"
                    @keyup.enter="selectChat(chat)"
                />
            </TransitionGroup>
            <ChatItem
                v-if="isChatsLoading"
                skeleton
            />
        </template>
        <template v-else>
            <ChatItem
                v-for="n in 15" :key="n"
                skeleton
            />
        </template>
    </div>
</template>

<style scoped>
    .v-enter-active,
    .v-leave-active {
        transition: all 0.75s ease;
    }

    .v-enter-from,
    .v-leave-to {
        opacity: 0;
        transform: translateY(30px);
    }
</style>
