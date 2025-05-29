<script setup>
import CircleAvatar from "@/Chat/User/CircleAvatar.vue";

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
    <div class="p-1.5 pl-2 flex gap-2 hover:bg-gray-300 rounded-lg">
        <CircleAvatar
            :src="user.avatar_thumb"
            :alt="user.name"
            :title="user.name"
            :class="{'invisible': !isLastSenderMessage}"
        />
        <div class="p-2 bg-white border-gray-300 rounded-lg cursor-default">
            {{ message.text }}
        </div>
    </div>
</template>

<style scoped>

</style>
