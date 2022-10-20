<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
    import { ref, useAttrs, onMounted, computed } from 'vue'
    import { Inertia } from '@inertiajs/inertia'
    import Label from '../../Components/Label.vue'
    import Input from '../../Components/Input.vue'
    import Button from '../../Components/Button.vue'

    import placeholderImage from '@/assets/images/placeholder-image.png'

    const attrs = useAttrs();
    const form = useForm({
        name: attrs.name,
        author: attrs.author,
        source: attrs.source,
        description: attrs.description,
        steps: attrs.steps ? attrs.steps : '',
        yield: attrs.yield,
        prepTime: attrs.prepTime,
        cookTime: attrs.cookTime,
        rating: attrs.rating,
        calories: attrs.calories,
        ingredients: attrs.ingredients ? attrs.ingredients : '',
        image: null,
        imageUrl: attrs.imageUrl ? form.imageUrl : placeholderImage
    });

    function submit() {
        form.post('/recipes/store', form)
    };

    function removeIngredient(index) {
        form.ingredients.splice(index, 1)
    };

    function addIngredient() {
        form.ingredients = [...form.ingredients, ''];
    };

    function removeStep(index) {
        form.steps.splice(index, 1)
    };

    function addStep() {
        form.steps = [...form.steps, {'@type': 'HowToStep', 'text': ''}];
    };
</script>

<template>
    <Head title="Create a recipe" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 leading-tight"
            >
                Create a recipe
            </h2>
        </template>

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
                        class="p-6 bg-white border-b border-gray-200"
                    >
                        <form
                            @submit.prevent="submit"
                            :disabled="form.processing"
                        >

                            <div class="md:flex flex-row-reverse justify-center align-middle">
                                <div
                                    class="rounded-full w-60 h-60 bg-center bg-cover m-auto"
                                    :style="{ backgroundImage: `url(${form.imageUrl})` }"
                                ></div>

                                <div class="w-full md:pr-5">
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
                                        class="bg-gray-50 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    />

                                    <div
                                        v-if="form.errors.name"
                                        class="text-sm text-red-600"
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
                                        v-model="form.description"
                                        type="text"
                                        class="block w-full text-md my-2 text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    ></textarea>

                                    <div
                                        v-if="form.errors.description"
                                        class="text-sm text-red-400"
                                    >
                                        {{ form.errors.description }}
                                    </div>
                                </div>
                            </div>

                            <div
                                class="w-full columns-1 sm:columns-2 lg:columns-3"
                            >
                                <!-- prepTime -->
                                <div
                                    class="flex-col w-full"
                                >
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
                                        class="bg-gray-50 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    />

                                    <div
                                        v-if="form.errors.prepTime"
                                        class="text-sm text-red-400"
                                    >
                                        {{ form.errors.prepTime }}
                                    </div>
                                </div>

                                <!-- cookTime -->
                                <div
                                    class="flex-col"
                                >
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
                                        class="bg-gray-50 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    />

                                    <div
                                        v-if="form.errors.cookTime"
                                        class="text-sm text-red-400"
                                    >
                                        {{ form.errors.cookTime }}
                                    </div>
                                </div>

                                <!-- yield -->
                                <div
                                    class="flex-col"
                                >
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
                                        class="bg-gray-50 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    />

                                    <div
                                        v-if="form.errors.yield"
                                        class="text-sm text-red-400"
                                    >
                                        {{ form.errors.yield }}
                                    </div>
                                </div>

                                <!-- calories -->
                                <div
                                    class="flex-col"
                                >
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
                                        class="bg-gray-50 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    />

                                    <div
                                        v-if="form.errors.calories"
                                        class="text-sm text-red-400"
                                    >
                                        {{ form.errors.calories }}
                                    </div>
                                </div>

                                <!-- rating -->
                                <div
                                    class="flex-col"
                                >
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
                                        class="bg-gray-50 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    />

                                    <div
                                        v-if="form.errors.rating"
                                        class="text-sm text-red-400"
                                    >
                                        {{ form.errors.rating }}
                                    </div>
                                </div>

                                <!-- author -->
                                <div
                                    class="flex-col"
                                >
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
                                        class="bg-gray-50 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    />

                                    <div
                                        v-if="form.errors.author"
                                        class="text-sm text-red-400"
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
                                class="bg-gray-50 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            />

                            <div
                                v-if="form.errors.source"
                                class="text-sm text-red-400"
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

                                <div
                                    class="relative"
                                    v-for="(ingredient, index) in form.ingredients"
                                    v-bind:key="index"
                                >
                                    <input
                                        :id="'recipe-ingredient-' + index"
                                        v-model="form.ingredients[index]"
                                        type="text"
                                        class="block w-full text-md my-2 text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    >

                                    <div
                                        @click="removeIngredient(index)"
                                        class="text-gray absolute right-1.5 bottom-1.5 h-8 w-1 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-full text-sm px-4 py-2 font-bold"
                                    >
                                        <p
                                            class="absolute right-3 bottom-1.5"
                                        >
                                            x
                                        </p>
                                    </div>
                                </div>

                                <div
                                    @click="addIngredient()"
                                    class="text-gray relative h-8 w-1 bg-blue-100 hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-full text-sm px-4 py-2 font-bold"
                                >
                                    <p
                                        class="absolute right-3 bottom-1.5"
                                    >
                                        +
                                    </p>
                                </div>
                            </div>

                            <!-- Steps -->
                            <div>
                                <label
                                    class="block pt-4 pb-1 font-medium text-sm text-gray-700"
                                >
                                    Steps
                                </label>

                                <div
                                    class="relative"
                                    v-for="(step, index) in form.steps"
                                    v-bind:key="index"
                                >
                                    <textarea
                                        ref="textAreas"
                                        :id="'recipe-step-' + index"
                                        v-model="form.steps[index].text"
                                        type="text"
                                        class="block w-full text-md my-2 text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    ></textarea>

                                    <div
                                        @click="removeStep(index)"
                                        class="text-gray absolute right-1.5 bottom-7 h-8 w-1 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-full text-sm px-4 py-2 font-bold"
                                    >
                                        <p
                                            class="absolute right-3 bottom-1.5"
                                        >
                                            x
                                        </p>
                                    </div>
                                </div>

                                <div
                                    @click="addStep()"
                                    class="mb-3 text-gray relative h-8 w-1 bg-blue-100 hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-full text-sm px-4 py-2 font-bold"
                                >
                                    <p
                                        class="absolute right-3 bottom-1.5"
                                    >
                                        +
                                    </p>
                                </div>
                            </div>

                            <Button>Save</Button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
