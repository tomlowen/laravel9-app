<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { useAttrs } from 'vue';
    import { Head } from '@inertiajs/inertia-vue3';

    const attrs = useAttrs();
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

                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
