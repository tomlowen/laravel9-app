<script setup>
    import { useForm, Link } from '@inertiajs/inertia-vue3';
    import Button from '../../Components/Button.vue';
    import { ref } from 'vue';

    const form = useForm({
        recipeUrl: null,
    });

    const loading = ref(false);

    function submit() {
        loading.value = true;
        form.post('/recipes/import', form)
        loading.value = false;
    };

</script>

<template>
        <div
            class="py-8"
        >
            <div
                class="max-w-7xl mx-auto sm:px-6 lg:px-8"
            >
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div
                        class="p-6 bg-white border-b border-gray-200"
                    >
                        <form
                            @submit.prevent="submit"
                            :disabled="form.processing"
                        >
                            <label
                                for="recipeUrl"
                                class="pb-1 pt-2 font-medium text-sm text-gray-700"
                            >
                                Enter a URL to import a recipe:
                            </label>

                            <input
                                id="recipeUrl"
                                v-model="form.recipeUrl"
                                type="text"
                                class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            />

                            <div
                                v-if="form.errors"
                                class="text-sm text-red-600"
                            >
                                {{ form.errors.recipeUrl }}
                            </div>

                            <div
                                class="flex align-middle mt-3"
                            >
                                <Button
                                    type="submit"

                                >
                                    Import recipe
                                </Button>

                                <p
                                    class="pb-1 pt-2 font-medium text-sm text-gray-700 mx-3 text-center"
                                >
                                    or
                                </p>

                                <Link
                                    href="/recipes/create"
                                    as="button"
                                >
                                    Create recipe
                                </Link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</template>
