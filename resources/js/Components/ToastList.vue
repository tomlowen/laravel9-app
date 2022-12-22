<script setup>
    import Toast from './Toast.vue';
    import { computed, watch, reactive } from 'vue';

    const props = defineProps({
        messages: Array,
        required: false
    })

    const currentPageMessage = computed(() => props.messages);
    const allMessages = reactive(props.messages);

    watch(currentPageMessage, (newValue, oldValue) => {
        allMessages.unshift(...newValue);
    }, {deep: true});

</script>

<template>
    <div>
        <Toast
            v-for="toast in allMessages"
            v-bind:key="toast.id"
            :message="toast"
        ></Toast>
    </div>
</template>
