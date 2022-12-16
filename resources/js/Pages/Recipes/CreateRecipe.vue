<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
    import { ref, useAttrs, onMounted, computed } from 'vue';
    import { Inertia } from '@inertiajs/inertia';
    import Label from '../../Components/Label.vue';
    import Input from '../../Components/Input.vue';
    import Button from '../../Components/Button.vue';
    import TextArea from '../../Components/TextArea.vue';
    import CategoryDropdown from '../../Components/Category/CategoryDropdown.vue';
    import placeholderImage from '@/assets/images/placeholder-image.png';
    import DeleteIcon from '../../Components/Icons/Delete.vue'

    const attrs = useAttrs();
    const form = useForm({
        recipeId: attrs.recipe ? attrs.recipe.data.id : null,
        name: attrs.recipe ? attrs.recipe.data.name : '',
        author: attrs.recipe ? attrs.recipe.data.author : '',
        description: attrs.recipe ? attrs.recipe.data.description : '',
        steps: attrs.recipe ? attrs.recipe.data.steps : [],
        source: attrs.recipe ? attrs.recipe.data.source : '',
        yield: attrs.recipe ? attrs.recipe.data.yield : '',
        prepTime: attrs.recipe ? attrs.recipe.data.prepTime : 0,
        cookTime: attrs.recipe ? attrs.recipe.data.cookTime : 0,
        rating: attrs.recipe ? attrs.recipe.data.rating : '',
        calories: attrs.recipe ? attrs.recipe.data.calories : '',
        ingredients: attrs.recipe ? attrs.recipe.data.ingredients.map((i) => {
                return {
                        'id': null,
                        'ingredient': i.ingredient,
                        'parse': i.parse
                    }
                }) : [],
        categories: attrs.recipe && attrs.recipe.data.categories ? attrs.recipe.data.categories.map((c) => c.slug) : [],
        image: null,
        imageUrl: attrs.recipe ? attrs.recipe.data.imageUrl : placeholderImage
    });

    onMounted(() => {
        const existingRecipe = attrs.recipe ? attrs.recipe.data.id : null;

        if (existingRecipe) {
            form.ingredients = attrs.recipe.data.ingredients.map((i) => {
                return {
                        'id': i.id,
                        'ingredient': `${i.quantity} ${i.unit} ${i.name}${i.notes ? ', ' + i.notes : ''}`,
                        'parse': false
                    }
                }
            )
            form.imageUrl = attrs.recipe.data.images ? '/storage/' + attrs.recipe.data.images[0].filename : placeholderImage
        }
    });

    function submit() {
        if (attrs.recipe && attrs.recipe.data.id) {
            form.put(`/recipes/${attrs.recipe.data.id}/update`, form)
        } else {
            form.post('/recipes/store', form)
        }
    };

    function removeIngredient(index) {
        form.ingredients.splice(index, 1)
    };

    function addIngredient() {
        form.ingredients.push(
            {
                'id': null,
                'ingredient': '',
                'parse': true
            }
        );
    };

    function flagParse(index) {
        form.ingredients[index].parse = true;
    }

    function removeStep(index) {
        form.steps.splice(index, 1)
    };

    function addStep() {
        form.steps = [...form.steps, {'@type': 'HowToStep', 'text': ''}];
    };

    function addCategory(category) {
        form.categories = [...form.categories, category];
    };

    function removeCategory(category) {
        const index = form.categories.indexOf(category);
        form.categories.splice(index, 1);
    };

    function changeImage(e) {
        if (e.target.files[0]) {
            form.image = e.target.files[0];
            form.imageUrl = URL.createObjectURL(form.image);
        } else {
            form.imageUrl = placeholderImage;
        }
    };

    function updateForm(field, value) {
        form[field] = value;
    }
</script>

<template>
    <Head title="Create a recipe" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 leading-tight"
            >
                {{$attrs.recipe && $attrs.recipe.data.id ? 'Update your recipe' : 'Create a recipe'}}
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

                            <div class="md:flex flex-row-reverse justify-between align-middle">
                                <!-- Image -->
                                <div class="overflow-hidden relative m-auto md:m-0">
                                    <div
                                        class="rounded-full w-60 h-60 bg-center m-auto md:m-0"
                                        :style="{ backgroundImage: `url(${form.imageUrl})` }"
                                    >
                                        <input
                                            class="h-full cursor-pointer absolute block py-2 px-4 w-full opacity-0 pin-r pin-t"
                                            type="file"
                                            name="documents[]"
                                            accept="image/*"
                                            @change="changeImage"
                                        >
                                    </div>
                                </div>

                                <div class="w-full md:w-2/3 md:mr-5">
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

                                    <TextArea :field="form.description" @updated:content="updateForm($event, 'description')"></TextArea>

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
                                        Preparation Time (minutes)
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
                                        Cooking Time (minutes)
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

                            <!-- Categories -->
                            <div>
                                <div>
                                    <label
                                        for="recipe-source"
                                        class="block pt-3 pb-1 font-medium text-sm text-gray-700"
                                    >
                                        Categories
                                    </label>
                                </div>
                                <div class="flex flex-wrap">
                                    <div
                                        v-for="(category, index) in form.categories"
                                        v-bind:key="index"
                                    >
                                        <div
                                            class="mr-2 text-xs inline-flex items-center font-bold leading-sm uppercase px-3 my-1 bg-blue-100 hover:bg-gray-300 rounded-full"
                                            @click="removeCategory(category)"
                                        >
                                            {{category}}
                                            <DeleteIcon
                                                class="pl-2"
                                            ></DeleteIcon>
                                        </div>
                                    </div>
                                </div>
                                <CategoryDropdown
                                    class="block"
                                    :userCategories="$attrs.categories.data"
                                    :recipeCategories="form.categories"
                                    @added:category="addCategory"
                                    @removed:category="removeCategory"
                                ></CategoryDropdown>
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
                                        v-model="form.ingredients[index].ingredient"
                                        @change="flagParse(index)"
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
                                    <TextArea
                                        :id="'recipe-step-' + index"
                                        :field="form.steps[index]"
                                        @updated:content="updateForm($event, 'steps')"
                                    ></TextArea>

                                    <div
                                        @click="removeStep(index)"
                                        class="text-gray absolute right-1.5 bottom-2 h-8 w-1 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-full text-sm px-4 py-2 font-bold"
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

                            <div class="flex justify-between">
                                <Link href="/recipes">
                                    <Button
                                        type="reset"
                                    >
                                        Cancel
                                    </Button>
                                </Link>
                                <Button>
                                    {{$attrs.recipe && $attrs.recipe.data.id ? 'Update' : 'Save'}}
                                </Button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
