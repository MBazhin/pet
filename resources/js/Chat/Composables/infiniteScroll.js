import {computed, nextTick, reactive, ref, toValue, watch} from "vue";
import {tryOnUnmounted} from "@vueuse/shared";
import {useElementVisibility, useScroll} from "@vueuse/core";

export const vInfiniteScroll = {
    mounted(el, binding) {
        useInfiniteScroll(el, binding.value);
    }
};

export function useInfiniteScroll(element, options = {}) {
    const {
        directions = {
            bottom: {
                canLoadMore: options.canLoadMore,
                onLoadMore: options.onLoadMore
            }
        },
        interval = 100,
        directionType = 'direct', // [direct(top->bottom,left->right)|reversed(bottom->top,right->left)]
    } = options;
    const state = reactive(useScroll(
        element,
        options
    ));
    const promise = ref();
    const isLoading = computed(() => !!promise.value);
    const observedElement = computed(() => {
        return resolveElement(toValue(element));
    });
    const isElementVisible = useElementVisibility(observedElement);

    function checkAndLoad() {
        state.measure();

        const requests = [];

        for (const direction in directions) {
            if (!observedElement.value || !isElementVisible.value || !directions[direction].canLoadMore(observedElement.value))
                continue;

            const {scrollHeight, clientHeight, scrollWidth, clientWidth} = observedElement.value;
            const isNarrower = direction === "bottom" || direction === "top" ? scrollHeight <= clientHeight : scrollWidth <= clientWidth;

            if (state.arrivedState[direction] || isNarrower) {
                requests.push(
                    withScrollShiftIfNeeded(directionType, state, observedElement, directions, direction)
                );
            }
        }

        if (requests.length && !promise.value) {
            promise.value = Promise.all([
                ...requests.map(request => request(state)),
                new Promise((resolve) => setTimeout(resolve, interval))
            ]).finally(() => {
                promise.value = null;
                nextTick(() => checkAndLoad());
            });
        }
    }

    const stop = watch(
        () => [
            ...Object.keys(directions).map(direction => state.arrivedState[direction]),
            isElementVisible.value
        ],
        checkAndLoad,
        {immediate: true}
    );

    tryOnUnmounted(stop);

    return {
        isLoading,
        reset() {
            nextTick(() => checkAndLoad());
        }
    };
}

function resolveElement(el) {
    if (typeof Window !== "undefined" && el instanceof Window)
        return el.document.documentElement;
    if (typeof Document !== "undefined" && el instanceof Document)
        return el.documentElement;
    return el;
}

function withScrollShiftIfNeeded(directionType, state, observedElement, directions, direction) {
    if (directionType === 'direct' && ['bottom', 'right'].includes(direction)
    || directionType === 'reversed' && ['top', 'left'].includes(direction))
        return directions[direction].onLoadMore;

    const {scrollHeight, scrollWidth} = observedElement.value;

    return (state) => {
        return directions[direction].onLoadMore(state)
            .then(() => {
                nextTick(() => {
                    const shiftDirection = directionType === 'direct' ? 1 : -1;

                    if (['top', 'bottom'].includes(direction)) {
                        const newScrollHeight = observedElement.value.scrollHeight;
                        observedElement.value.scrollTop = (newScrollHeight - scrollHeight) * shiftDirection;
                    } else if (['left', 'right'].includes(direction)) {
                        const newScrollWidth = observedElement.value.scrollWidth;
                        observedElement.value.scrollLeft = (newScrollWidth - scrollWidth) * shiftDirection;
                    }
                });
            });
    };
}
