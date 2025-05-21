import {ref, watch} from "vue";
import defaultChat from "@/Chat/Composables/Defaults/chat.js";
import {useInfiniteAxiosViaLaravelCursor} from "@/Chat/Composables/infiniteAxiosViaLaravelCursor.js";

const apiUrl = '/api/chat'; //todo заменить на ziggy или wayfinder

const chats = ref([]);
const selectedChat = ref(defaultChat());

const {
    data,
    initialLoadingCompleted,
    isLoading: isChatsLoading,
    canLoadMoreForward: canLoadMoreChats,
    loadDataForward: loadChats,
} = useInfiniteAxiosViaLaravelCursor(apiUrl);

watch(data, ({data: receivedChats}) => {
    canLoadMoreChats.value
        ? chats.value.push(...receivedChats)
        : chats.value = receivedChats;
});

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
