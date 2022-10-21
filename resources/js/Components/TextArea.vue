<script setup>
    import { ref, onMounted } from 'vue'

    const textarea = ref(null);

    defineProps({
        modelValue: {
            type: String,
            required: true,
            default: '',
        },
    });

    onMounted(() => textarea.value.style.height = textarea.value.scrollHeight + 4  + 'px');

    function resize() {
        textarea.value.style.height = textarea.value.scrollHeight + 'px';
    }

</script>

<template>
    <textarea
        v-model="modelValue"
        ref="textarea"
        rows="3"
        @input="resize"
        @focus="resize"
        @keyup="resize"
        class="block w-full text-md my-2 text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
    >
    </textarea>
</template>
