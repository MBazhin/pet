import {useInfiniteAxiosViaLaravelCursor} from "@/Chat/Composables/infiniteAxiosViaLaravelCursor.js";
import {computed, reactive, toRefs} from "vue";

const apiUrl = '/api/chat/:chatId/messages'; //todo заменить на ziggy или wayfinder

//todo оптимизировать?
const chatsMessages = reactive(new Map());

const chatsLastMessages = computed(() => {
    return Array.from(chatsMessages.entries())
        .reduce((map, [chatId, messagesComposable]) => {
            map.set(chatId, messagesComposable.messages[0]);
            return map;
        }, new Map());
});

export function useMessages(chat) {
    if (!chatsMessages.has(chat.id)) {
        const url = apiUrl.replace(':chatId', chat.id);

        const {
            items: messages,
            initialLoadingCompleted,
            canLoadMoreForward: canLoadMoreMessagesForward,
            canLoadMoreBackward: canLoadMoreMessagesBackward,
            loadDataForward: loadMessagesForward,
            loadDataBackward: loadMessagesBackward,
        } = useInfiniteAxiosViaLaravelCursor(url, chat.last_message ? [chat.last_message] : []);

        chatsMessages.set(chat.id, {
            messages,
            initialLoadingCompleted,
            canLoadMoreMessagesForward,
            canLoadMoreMessagesBackward,
            loadMessagesForward,
            loadMessagesBackward,
        });
    }

    return toRefs(chatsMessages.get(chat.id));
}

export function useChatsLastMessages() {
    return {
        chatsLastMessages,
    }
}

export function addMessage(chat, message) {
    chatsMessages.get(chat.id).messages.unshift(message);
}
