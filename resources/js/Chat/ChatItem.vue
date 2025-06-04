<script setup>
import Name from "@/Chat/User/Name.vue";
import CircleAvatar from "@/Chat/User/CircleAvatar.vue";
import MessageTime from "@/Chat/Messages/MessageTime.vue";
import {computed} from "vue";
import {useChatsLastMessages} from "@/Chat/Composables/messages.js";
import defaultChat from "@/Chat/Composables/Defaults/chat.js";

const {chat, skeleton} = defineProps({
    chat: {
        type: Object,
        default: () => defaultChat(),
    },
    highlight: Boolean,
    skeleton: Boolean
});

const {chatsLastMessages} = useChatsLastMessages();

const lastMessage = computed(() => chatsLastMessages.value.get(chat.id));
</script>

<template>
    <div
        tabindex="0"
        class="relative rounded-xl cursor-pointer h-18 p-2 flex gap-3 items-center transition-colors"
        :class="[
            highlight ? 'bg-gray-200' : 'hover:bg-gray-100',
            skeleton ? 'animate-pulse hover:bg-inherit !cursor-default' : 'focus:outline-0 focus:bg-gray-200'
        ]"
    >
        <div
            v-if="skeleton"
            class="w-[50px] h-[50px] rounded-full bg-gray-200 shrink-0"
        />
        <CircleAvatar
            v-else
            :src="chat.avatar_thumb"
            alt="Аватар"
        />

        <div class="grow-1 flex flex-col" :class="{'gap-2': skeleton}">
            <template v-if="skeleton">
                <div class="h-4.5 bg-gray-200 rounded-full max-w-56"/>

                <div class="h-3.5 bg-gray-200 rounded-full"/>
            </template>
            <template v-else>
                <Name :name="chat.name"/>

                <div
                    v-if="lastMessage"
                    class="flex justify-between items-baseline"
                >
                    <span class="text-gray-700 text-sm break-all line-clamp-1"
                    >{{ lastMessage.text }}</span>

                    <MessageTime :time="lastMessage.created_at"/>
                </div>
            </template>
        </div>

        <span v-if="skeleton" class="sr-only">Загрузка чата...</span>
    </div>
</template>

<style scoped>

</style>
