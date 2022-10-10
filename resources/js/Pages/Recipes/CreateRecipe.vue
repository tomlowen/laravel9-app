<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
    import { ref, useAttrs } from 'vue'
    import { Inertia } from '@inertiajs/inertia'
    import Label from '../../Components/Label.vue'
    import Input from '../../Components/Input.vue'
    import Button from '../../Components/Button.vue'

    const attrs = useAttrs();
    const form = useForm({
        name: attrs.name,
        author: attrs.author,
        source: attrs.source,
        description: attrs.description,
        steps: attrs.steps,
        yield: attrs.yield,
        prepTime: attrs.preparation_time,
        cookTime: attrs.cooking_time,
        rating: attrs.rating,
        calories: attrs.calories,
        ingredients: attrs.ingredients,
    });

    function submit() {
        form.post('/recipes/store', form)
    };
</script>

<template>
    <Head title="Create a recipe" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create a recipe
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit" :disabled="form.processing">

                            <!-- name -->
                            <label
                                for="recipe-name"
                                class="block pb-1 font-medium text-sm text-gray-700"
                            >
                                Name
                            </label>
                            <input
                                id="recipe-name"
                                type="text"
                                v-model="form.name"
                                class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            />
                            <div
                                v-if="form.errors.name"
                            >
                                {{ form.errors.name }}
                            </div>

                            <!-- description -->
                            <label
                                for="recipe-description"
                                class="pt-3 pb-1 block font-medium text-sm text-gray-700"
                            >
                                Description
                            </label>
                            <textarea
                                id="recipe-description"
                                type="text"
                                v-model="form.description"
                                class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            ></textarea>
                            <div
                                v-if="form.errors.description"
                            >
                                {{ form.errors.description }}
                            </div>

                            <div class="w-full columns-1 sm:columns-2 lg:columns-3">
                                <!-- prepTime -->
                                <div class="flex-col w-full">
                                    <label
                                        for="recipe-prepTime"
                                        class="pb-1 pt-2 font-medium text-sm text-gray-700"
                                    >
                                        Preparation Time
                                    </label>
                                    <input
                                        id="recipe-prepTime"
                                        type="text"
                                        v-model="form.prepTime"
                                        class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    />
                                    <div
                                        v-if="form.errors.prepTime"
                                    >
                                        {{ form.errors.prepTime }}
                                    </div>
                                </div>

                                <!-- cookTime -->
                                <div class="flex-col">
                                    <label
                                        for="recipe-cookTime"
                                        class="pb-1 pt-2 font-medium text-sm text-gray-700"
                                    >
                                        Cooking Time
                                    </label>
                                    <input
                                        id="recipe-cookTime"
                                        type="text"
                                        v-model="form.cookTime"
                                        class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    />
                                    <div
                                        v-if="form.errors.cookTime"
                                    >
                                        {{ form.errors.cookTime }}
                                    </div>
                                </div>

                                <!-- yield -->
                                <div class="flex-col">
                                    <label
                                        for="recipe-yield"
                                        class="pb-1 pt-2 font-medium text-sm text-gray-700"
                                    >
                                        Servings
                                    </label>
                                    <input
                                        id="recipe-yield"
                                        type="text"
                                        v-model="form.yield"
                                        class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    />
                                    <div
                                        v-if="form.errors.yield"
                                    >
                                        {{ form.errors.yield }}
                                    </div>
                                </div>

                                <!-- calories -->
                                <div class="flex-col">
                                    <label
                                        for="recipe-calories"
                                        class="pb-1 pt-2 font-medium text-sm text-gray-700"
                                    >
                                        Calories
                                    </label>
                                    <input
                                        id="recipe-calories"
                                        type="text"
                                        v-model="form.calories"
                                        class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    />
                                    <div
                                        v-if="form.errors.calories"
                                    >
                                        {{ form.errors.calories }}
                                    </div>
                                </div>

                                <!-- rating -->
                                <div class="flex-col">
                                    <label
                                        for="recipe-rating"
                                        class="pb-1 pt-2 font-medium text-sm text-gray-700"
                                    >
                                        Rating
                                    </label>
                                    <input
                                        id="recipe-rating"
                                        type="text"
                                        v-model="form.rating"
                                        class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    />
                                    <div
                                        v-if="form.errors.rating"
                                    >
                                        {{ form.errors.rating }}
                                    </div>
                                </div>

                                <!-- author -->
                                <div class="flex-col">
                                    <label
                                        for="recipe-author"
                                        class="pb-1 pt-2 font-medium text-sm text-gray-700"
                                    >
                                        Author
                                    </label>
                                    <input
                                        id="recipe-author"
                                        type="text"
                                        v-model="form.author"
                                        class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    />
                                    <div
                                        v-if="form.errors.author"
                                    >
                                        {{ form.errors.author }}
                                    </div>
                                </div>
                            </div>

                            <!-- source -->
                            <label
                                for="recipe-source"
                                class="block pt-3 pb-1 font-medium text-sm text-gray-700"
                            >
                                Source
                            </label>
                            <input
                                id="recipe-source"
                                type="text"
                                v-model="form.source"
                                class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            />
                            <div
                                v-if="form.errors.source"
                            >
                                {{ form.errors.source }}
                            </div>

                            <!-- Ingredients -->
                            <div>
                            <label
                                class="block pt-3 pb-1 font-medium text-sm text-gray-700"
                            >
                                Ingredients
                            </label>
                            <input
                                v-for="(ingredient, index) in form.ingredients"
                                v-bind:key="index"
                                :id="'recipe-ingredient-' + index"
                                type="text"
                                v-model="form.ingredients[index]"
                                class="block w-full sm:w-1/2 mb-3 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            />
                            </div>

                            <!-- Steps -->
                            <div>
                            <label
                                class="block pt-3 pb-1 font-medium text-sm text-gray-700"
                            >
                                Steps
                            </label>
                            <textarea
                                v-for="(step, index) in form.steps"
                                v-bind:key="index"
                                :id="'recipe-step-' + index"
                                type="text"
                                v-model="form.steps[index].text"
                                class="block w-full mb-3 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            ></textarea>
                            </div>

                            <Button>Save</Button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
