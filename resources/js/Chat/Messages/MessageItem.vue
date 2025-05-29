<script setup>
import CircleAvatar from "@/Chat/User/CircleAvatar.vue";
import MessageTime from "@/Chat/Messages/MessageTime.vue";

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
            <div class="flex justify-between items-end">
                <span>{{ message.text }}</span>

                <MessageTime :time="message.created_at"/>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
