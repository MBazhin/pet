<script setup>
import BreakpointInfo from "@/Chat/Heplers/BreakpointInfo.vue";
import ChatPanel from "@/Chat/ChatPanel.vue";
import TelescopeLink from "@/Chat/Heplers/TelescopeLink.vue";
import {useAuth} from "@/Chat/Composables/auth.js";
import CircleAvatar from "@/Chat/User/CircleAvatar.vue";
import Name from "@/Chat/User/Name.vue";

const {user} = useAuth();
</script>

<template>
    <TelescopeLink class="bottom-12"/>
    <BreakpointInfo class="bottom-0"/>
    <div class="w-screen h-screen bg-gray-200">
        <div class="sm:max-w-2xl lg:max-w-4xl xl:max-w-5xl 2xl:max-w-6xl mx-auto h-full">
            <div class="h-16 w-full text-center px-2">
                <div class="h-full hover:bg-gray-300 transition-colors rounded-b-xl p-3 flex justify-between items-center">
                    <a class="justify-self-end text-white bg-blue-700 hover:bg-blue-600 hover:shadow-lg py-2 px-3 rounded-lg" href="/">На главную</a>
                    <div class="flex items-center gap-3">
                        <Name :name="user.name"/>
                        <CircleAvatar :src="user.avatar_thumb" :alt="user.name"/>
                    </div>
                </div>
            </div>
            <ChatPanel/>
        </div>
    </div>
</template>

<style scoped>

</style>
