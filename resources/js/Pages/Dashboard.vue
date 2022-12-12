<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import ChevronLeft from '../Components/Icons/ChevronLeft.vue';
    import AddRecipeTool from '../Components/Recipe/AddRecipeTool.vue'
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        You're logged in!
                    </div>
                </div>
            </div>
        </div>

        <div class="">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 md:flex align-middle">
                        <Link :href="route('dashboard')">
                            <img
                                src="@/assets/images/logo.png"
                                class="h-48 m-auto md:ml-0"
                            />
                        </Link>
                        <div class="md:pl-5 mt-5 md:mt-0 text-2xl">
                            <h1>Welcome to Frankie's Kitchen!</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <AddRecipeTool></AddRecipeTool>
    </BreezeAuthenticatedLayout>
</template>
