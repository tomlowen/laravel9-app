<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { useAttrs, ref } from 'vue';
    import { Head } from '@inertiajs/inertia-vue3';
    import AddToShoppingListModal from '../../Components/ShopplingList/AddToShoppingListModal.vue';
    import Button from '../../Components/Button.vue';

    const attrs = useAttrs();
    const modalVisible = ref(false);

    function toggleModal() {
        modalVisible.value = !modalVisible.value;
    }
</script>

<template>
    <Head
        title="Settings"
    />

    <BreezeAuthenticatedLayout>
        <div
            class="py-12"
        >
            <div
                class="max-w-7xl mx-auto sm:px-6 lg:px-8"
            >
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div
                        class="p-6 bg-white border-b border-gray-200 flex flex-col sm:flex-wrap sm:flex-row grow"
                    >
                        <Button @click="toggleModal">Toggle modal</Button>
                        <AddToShoppingListModal :modalVisible="modalVisible" @toggled:modal="toggleModal"></AddToShoppingListModal>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
