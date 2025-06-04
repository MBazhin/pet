<script setup>
import CircleAvatar from "@/Chat/User/CircleAvatar.vue";
import MessageTime from "@/Chat/Messages/MessageTime.vue";
import {computed} from "vue";
import {useMessage} from "@/Chat/Composables/message.js";

const {message} = defineProps({
    message: {
        type: Object,
        required: true
    },
    user: {
        type: Object,
        required: true
    },
    isLastSenderMessage: {
        type: Boolean,
        required: true,
    }
});

const emit = defineEmits({
    retryStore: null
});

const {isErrorState} = useMessage();

const errorState = computed(() => isErrorState(message));

function handleErrorButtonClick() {
    emit('retryStore');
}
</script>

<template>
    <div
        tabindex="0"
        class="p-1.5 pl-2 flex gap-2 hover:bg-gray-300 rounded-lg focus:outline-0 focus:bg-gray-300"
    >
        <CircleAvatar
            :src="user.avatar_thumb"
            :alt="user.name"
            :title="user.name"
            :class="{'invisible': !isLastSenderMessage}"
        />
        <div class="p-2 bg-white border-gray-300 rounded-lg cursor-default">
            <div class="flex justify-between items-end gap-1">
                <span class="whitespace-break-spaces">{{ message.text }}</span>

                <div class="flex flex-col items-end gap-1">
                    <button
                        v-if="errorState"
                        title="Повторить"
                        class="bg-red-500 rounded-full size-3.5 cursor-pointer"
                        @click="handleErrorButtonClick"
                    />
                    <MessageTime :time="message.created_at"/>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
