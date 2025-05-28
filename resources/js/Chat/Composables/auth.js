import { computed, reactive } from 'vue'

const state = reactive({
    authenticated: false,
    user: {}
})

export function useAuth() {
    const authenticated = computed(() => state.authenticated);
    const user = computed(() => state.user);

    const setAuthenticated = (authenticated) => {
        state.authenticated = authenticated;
    }

    const setUser = (user) => {
        state.user = user;
    }

    const attempt = async (user) => {
        try {
            if (user) {
                return new Promise(resolve => {
                    setAuthenticated(true);
                    setUser(user);
                    resolve();
                });
            }
        } catch (e) {
            setAuthenticated(false);
            setUser({});
        }
    }

    return {
        authenticated,
        user,
        attempt
    }
}
