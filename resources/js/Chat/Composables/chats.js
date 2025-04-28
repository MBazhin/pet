import {computed, ref} from "vue";
import {useThrottleFn} from "@vueuse/core";
import defaultChat from "@/Chat/Composables/Defaults/chat.js";

const apiUrl = '/api/chat'; //todo заменить на ziggy или wayfinder

const chats = ref([]);
const selectedChat = ref(defaultChat());

const initialLoadingCompleted = ref(false);
const busy = ref(false);
const next = ref(null);

export function useChats() {
    const canLoadMoreChats = computed(() => !!next.value);

    const loadChats = useThrottleFn(() => {
        busy.value = true;
        axios.get(next.value ?? apiUrl)
            .then(({data}) => {
                const {data: receivedChats, links} = data;

                next.value
                    ? chats.value.push(...receivedChats)
                    : chats.value = receivedChats;

                next.value = links.next;
            })
            .finally(() => {
                busy.value = false;
                initialLoadingCompleted.value = true;
            })
    }, 2000);

    const selectChat = (chat) => selectedChat.value = selectedChat.value.id === chat.id
        ? defaultChat()
        : chat;

    return {
        chats,
        selectedChat,
        initialLoadingCompleted,
        canLoadMoreChats,
        busy,
        loadChats,
        selectChat,
    }
}
