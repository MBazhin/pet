import {computed, ref} from "vue";
import {useAxios} from "@vueuse/integrations/useAxios";

export function useInfiniteAxiosViaLaravelCursor(loadDataUrl) {
    const items = ref([]);
    const next = ref(false);
    const prev = ref(false);
    const initialLoadingCompleted = ref(false);

    const {
        error,
        isLoading,
        execute
    } = useAxios(loadDataUrl, {}, {immediate: false});

    const canLoadMoreForward = computed(() => next.value && !error.value);
    const canLoadMoreBackward = computed(() => prev.value && !error.value);

    const loadDataForward = () => loadData();
    const loadDataBackward = () => loadData(false);

    function loadData(forward = true) {
        if (!initialLoadingCompleted.value) return execute(loadDataUrl)
            .then(response => {
                const {data, links} = response.data.value;

                next.value = links.next;
                prev.value = links.prev;

                initialLoadingCompleted.value = true;

                items.value = data;
            })

        if (forward) return execute(next.value)
            .then(response => {
                const {data, links} = response.data.value;

                next.value = links.next;

                items.value.push(...data)
            });
        else return execute(prev.value)
            .then(response => {
                const {data, links} = response.data.value;

                prev.value = links.prev;

                items.value.unshift(...data);
            });
    }

    return {
        items,
        error,
        isLoading,
        initialLoadingCompleted,
        canLoadMoreForward,
        canLoadMoreBackward,
        loadDataForward,
        loadDataBackward,
    }
}
