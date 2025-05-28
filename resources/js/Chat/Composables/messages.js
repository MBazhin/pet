import {useInfiniteAxiosViaLaravelCursor} from "@/Chat/Composables/infiniteAxiosViaLaravelCursor.js";

const apiUrl = '/api/chat/:chatId/messages'; //todo заменить на ziggy или wayfinder

export function useMessages(chatId) {
    const url = apiUrl.replace(':chatId', chatId);

    const {
        items: messages,
        canLoadMoreForward: canLoadMoreMessagesForward,
        canLoadMoreBackward: canLoadMoreMessagesBackward,
        loadDataForward: loadMessagesForward,
        loadDataBackward: loadMessagesBackward,
    } = useInfiniteAxiosViaLaravelCursor(url);

    return {
        messages,
        canLoadMoreMessagesForward,
        canLoadMoreMessagesBackward,
        loadMessagesForward,
        loadMessagesBackward
    }
}
