import {ref} from "vue";
import defaultChat from "@/Chat/Composables/Defaults/chat.js";
import {useInfiniteAxiosViaLaravelCursor} from "@/Chat/Composables/infiniteAxiosViaLaravelCursor.js";
import {useMessages} from "@/Chat/Composables/messages.js";

const apiUrl = '/api/chat'; //todo заменить на ziggy или wayfinder

const selectedChat = ref(defaultChat());

const {
    items: chats,
    initialLoadingCompleted,
    isLoading: isChatsLoading,
    canLoadMoreForward: canLoadMoreChats,
    loadDataForward,
} = useInfiniteAxiosViaLaravelCursor(apiUrl);

function loadChats() {
    return loadDataForward()
        .then(chats =>
            chats.forEach(chat => useMessages(chat)));
}

function selectChat(chat) {
    selectedChat.value = selectedChat.value.id === chat.id
        ? defaultChat()
        : chat;
}

export function useChats() {
    return {
        chats,
        selectedChat,
        canLoadMoreChats,
        isChatsLoading,
        initialLoadingCompleted,
        loadChats,
        selectChat,
    }
}
