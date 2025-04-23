<script setup>
import BreakpointInfo from "@/Chat/Heplers/BreakpointInfo.vue";
import { ref } from 'vue'
import ChatList from "@/Chat/ChatList.vue";

const chats = ref([
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
    {name: '123'},
])
</script>

<template>
    <div class="w-screen h-screen bg-gray-200">
        <div class="sm:max-w-2xl lg:max-w-4xl xl:max-w-5xl 2xl:max-w-6xl mx-auto h-full">
            <div class="flex gap-3 h-full p-3">
                <ChatList
                    class="flex-2 bg-white rounded-l-xl border border-gray-200 overflow-y-auto"
                    :chats="chats"
                />
                <div class="flex-3 bg-white rounded-r-xl border border-gray-200">
                    <div class="flex h-full justify-center items-center">
                        <p class="text-2xl text-gray-400">
                            Выберите чат
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <BreakpointInfo/>
</template>

<style scoped>

</style>
