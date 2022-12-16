<script setup>
    import { ref, onMounted } from 'vue'

    const textarea = ref(null);

    defineProps({
        field: {
            type: String,
            required: true,
            default: '',
        },
    });

    const emit = defineEmits(['updated:content'])


    onMounted(() => textarea.value.style.height = textarea.value.scrollHeight + 4  + 'px');

    function emitChange(e) {
        emit('updated:content', e.target.value);
        resize()
    }

    function resize() {
        textarea.value.style.height = textarea.value.scrollHeight + 'px';
    }

</script>

<template>
    <textarea
        :value="field"
        ref="textarea"
        rows="1"
        @input="emitChange"
        @focus="resize"
        @keyup="resize"
        class="block w-full text-md my-2 text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
    >
    </textarea>
</template>
