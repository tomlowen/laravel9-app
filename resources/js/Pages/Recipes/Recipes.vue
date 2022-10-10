<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import { ref } from 'vue'
    import { Inertia } from '@inertiajs/inertia'
    import { useForm } from '@inertiajs/inertia-vue3'

    const loading = ref(false);
    const form = useForm({
        recipeUrl: null,
    });

    function submit() {
        loading.value = true;
        form.post('/recipes/import', form)
        loading.value = false;
    };
</script>

<template>
    <Head title="All Recipes" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Recipes
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <Link href="/recipe/create" as="button">Create a recipe</Link>
                        <form @submit.prevent="submit" :disabled="form.processing">
                            <label for="recipe-url">Enter a URL to import a recipe from:</label>
                            <input id="recipe-url" v-model="form.recipeUrl" />
                            <button type="submit">Import a recipe</button>
                            <div v-if="loading">Loading</div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
