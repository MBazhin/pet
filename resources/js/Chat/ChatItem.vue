<script setup>
import moment from 'moment';
import Name from "@/Chat/User/Name.vue";
import CircleAvatar from "@/Chat/User/CircleAvatar.vue";

defineProps({
    chat: {
        type: Object,
        required: true,
    },
    highlight: Boolean,
    skeleton: Boolean
});
</script>

<template>
    <div
        class="relative rounded-xl cursor-pointer h-18 p-2 flex gap-3 items-center transition-colors"
        :class="[
            highlight ? 'bg-gray-200' : 'hover:bg-gray-100',
            { 'animate-pulse hover:bg-inherit !cursor-default': skeleton }
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

                <div v-if="chat.last_message" class="flex justify-between items-baseline">
                    <span class="text-gray-700 text-sm break-all line-clamp-1"
                    >{{ chat.last_message.text }}</span>

                    <span class="text-gray-700 text-xs whitespace-nowrap"
                    >{{ moment(chat.last_message.created_at).format('H:mm') }}</span>
                </div>
            </template>
        </div>

        <span v-if="skeleton" class="sr-only">Загрузка чата...</span>
    </div>
</template>

<style scoped>

</style>
