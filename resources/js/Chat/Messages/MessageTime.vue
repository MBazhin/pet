<script setup>
import moment from 'moment';

defineProps({
    time: {
        type: String,
        required: true,
    }
})
</script>

<template>
    <span class="text-gray-700 text-xs whitespace-nowrap"
    >{{ moment(time).format('H:mm') }}</span>
</template>

<style scoped>

</style>
