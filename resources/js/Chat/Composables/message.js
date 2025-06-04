import moment from "moment";
import {md5} from "js-md5";
import {reactive} from "vue";
import {useAuth} from "@/Chat/Composables/auth.js";

const PENDING_MESSAGE_STATE = 'pending';
const FINISHED_MESSAGE_STATE = 'finished';
const ERROR_MESSAGE_STATE = 'error';

const apiUrl = '/api/chat/:chatId/messages'; //todo заменить на ziggy или wayfinder

const {user} = useAuth();

function makeMessage(text, senderId, createdAt, id = null) {
    if (!senderId) senderId = user.value.id;
    if (!createdAt) createdAt = moment().toISOString();
    if (!id) id = md5(`${text}_${senderId}_${createdAt}`);

    return reactive({
        id,
        text,
        sender_id: senderId,
        created_at: createdAt,
        state: PENDING_MESSAGE_STATE,
    });
}

function storeMessage(message, chat, params) {
    const url = apiUrl.replace(':chatId', chat.id);

    setPendingState(message);

    return axios.post(url, params)
        .then(({data: savedMessage}) => {
            message.id = savedMessage.id;
            message.created_at = savedMessage.created_at;
            setFinishedState(message);
        })
        .catch(error => {
            console.log(message.text, error);
            setErrorState(message);
            alert('Ошибка при отправке сообщения');
        })
}

function setPendingState(message) {
    message.state = PENDING_MESSAGE_STATE;
}

function setErrorState(message) {
    message.state = ERROR_MESSAGE_STATE;
}

function setFinishedState(message) {
    message.state = FINISHED_MESSAGE_STATE;
}

function isErrorState(message) {
    return message.state === ERROR_MESSAGE_STATE;
}

export function useMessage() {
    return {
        makeMessage,
        storeMessage,
        isErrorState
    }
}
