<script setup>
import {useTextareaAutosize} from "@vueuse/core";
import {onActivated} from "vue";

const input = defineModel({ required: true });

const emit = defineEmits({
    submit: null
});

const { textarea } = useTextareaAutosize({ styleProp: 'minHeight', input });

onActivated(() => {
    textarea.value.focus();
})

function handleMessageSubmit() {
    emit('submit');
}
</script>

<template>
    <div class="relative bg-white rounded-br-lg w-full pb-1 p-2">
        <textarea
            ref="textarea"
            id="messageTextareaInput"
            v-model="input"
            class="resize-none w-full ps-3 py-3 pe-14 border rounded-r-lg
                border-gray-400 focus:outline-0 focus:border-blue-500 focus:ring focus:ring-blue-500"
            placeholder="Ваше сообщение..."
            rows="2"
        />
        <button
            type="button"
            class="absolute bottom-5.5 right-4.5 inline-flex justify-center p-3 text-blue-600 rounded-full hover:bg-blue-100"
            title="Отправить сообщение"
            @click="handleMessageSubmit"
        >
            <svg class="size-6 rotate-90 rtl:-rotate-90" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                <path d="m17.914 18.594-8-18a1 1 0 0 0-1.828 0l-8 18a1 1 0 0 0 1.157 1.376L8 18.281V9a1 1 0 0 1 2 0v9.281l6.758 1.689a1 1 0 0 0 1.156-1.376Z"/>
            </svg>
            <span class="sr-only">Отправить сообщение</span>
        </button>
    </div>
</template>

<style scoped>
    textarea {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    textarea::-webkit-scrollbar {
        display: none;
    }
</style>
