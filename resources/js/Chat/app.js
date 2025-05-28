import '@/bootstrap';
import {createApp} from "vue";
import App from "@/Chat/App.vue";
import {useAuth} from '@/chat/composables/auth.js';

const rootContainer = document.getElementById('app');

const auth = JSON.parse(rootContainer.dataset.auth);

const {attempt} = useAuth();

attempt(auth).then(() => {
    createApp(App).mount(rootContainer)
});
