<script setup>
import ChatItem from "@/Chat/ChatItem.vue";
import {vInfiniteScroll} from '@vueuse/components'
import {useChats} from "@/Chat/Composables/chats.js";
import {onMounted} from "vue";

const {chats, selectedChat, initialLoadingCompleted, canLoadMoreChats, busy, loadChats, selectChat} = useChats();

onMounted(() => {
    loadChats();
});
</script>

<template>
    <div
        class="bg-white rounded-l-xl
               border border-gray-200
               overflow-y-auto overflow-x-hidden
               flex flex-col gap-2 p-2"
        :class="{'overflow-y-hidden': !initialLoadingCompleted}"
        v-infinite-scroll="[
            loadChats,
            { distance: 175, canLoadMore: () => canLoadMoreChats && !busy }
        ]"
    >
        <template v-if="initialLoadingCompleted">
            <TransitionGroup>
                <ChatItem
                    v-for="(chat, index) in chats" :key="index"
                    :chat="chat"
                    :highlight="selectedChat.id === chat.id"
                    @click="selectChat(chat)"
                />
            </TransitionGroup>
            <ChatItem
                v-if="canLoadMoreChats"
                skeleton
                :chat="{}"
            />
        </template>
        <template v-else>
            <ChatItem
                v-for="n in 15" :key="n"
                skeleton
                :chat="{}"
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
