import {ref} from "vue";
import defaultChat from "@/Chat/Composables/Defaults/chat.js";
import {useInfiniteAxiosViaLaravelCursor} from "@/Chat/Composables/infiniteAxiosViaLaravelCursor.js";

const apiUrl = '/api/chat'; //todo заменить на ziggy или wayfinder

const selectedChat = ref(defaultChat());

const {
    items: chats,
    initialLoadingCompleted,
    isLoading: isChatsLoading,
    canLoadMoreForward: canLoadMoreChats,
    loadDataForward: loadChats,
} = useInfiniteAxiosViaLaravelCursor(apiUrl);

const selectChat = (chat) => selectedChat.value = selectedChat.value.id === chat.id
    ? defaultChat()
    : chat;

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
