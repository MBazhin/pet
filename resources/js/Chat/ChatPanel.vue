<script setup>
import ChatList from "@/Chat/ChatList.vue";
import MessagesWindow from "@/Chat/Messages/MessagesWindow.vue";
</script>

<template>
    <div class="grid grid-cols-12 gap-3 h-full p-3">
        <ChatList
            class="col-span-3 sm:col-span-2 lg:col-span-4"
        />
        <MessagesWindow
            class="col-span-9 sm:col-span-10 lg:col-span-8"
        />
    </div>
</template>

<style scoped>

</style>
