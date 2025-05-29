<script setup>
import MessagesList from "@/Chat/Messages/MessagesList.vue";
import MessageInput from "@/Chat/Messages/MessageInput.vue";
import {ref} from "vue";

const {chat} = defineProps({
    chat: {
        type: Object,
        required: true,
    }
});

const input = ref();
</script>

<template>
    <!--flex-col-reverse для корректной последовательности tabindex-->
    <div class="h-full flex flex-col-reverse overflow-y-auto overflow-x-hidden">
        <MessageInput
            v-model="input"
            @submit="console.log(input)"
        />
        <MessagesList
            :chat="chat"
        />
    </div>
</template>

<style scoped>

</style>
