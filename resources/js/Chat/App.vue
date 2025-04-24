<script setup>
import BreakpointInfo from "@/Chat/Heplers/BreakpointInfo.vue";
import ChatPanel from "@/Chat/ChatPanel.vue";
import TelescopeLink from "@/Chat/Heplers/TelescopeLink.vue";
</script>

<template>
    <div class="w-screen h-screen bg-gray-200">
        <div class="sm:max-w-2xl lg:max-w-4xl xl:max-w-5xl 2xl:max-w-6xl mx-auto h-full">
            <ChatPanel/>
        </div>
    </div>
    <TelescopeLink class="bottom-12"/>
    <BreakpointInfo class="bottom-0"/>
</template>

<style scoped>

</style>
