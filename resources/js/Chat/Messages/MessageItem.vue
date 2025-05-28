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
});
</script>

<template>
    <div class="p-2 border-gray-300 flex gap-4">
        <CircleAvatar
            :src="user.avatar_thumb"
            :alt="user.name"
        />
        {{ message.text }}
    </div>
</template>

<style scoped>

</style>
