<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { ref, reactive, computed, useAttrs } from 'vue';
    import { Inertia } from '@inertiajs/inertia';
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import Button from '../../Components/Button.vue';
    import RecipeCard from '../../Components/Recipe/RecipeCard.vue';
    import CategorySelector from '../../Components/Category/CategorySelector.vue';
    import AddRecipeTool from '../../Components/Recipe/AddRecipeTool.vue'

    const attrs = useAttrs();

    const state = reactive({
        selectedCategories: [],
    })

    const recipes = computed(() => {
        if (state.selectedCategories.length === 0) {
            return attrs.recipes.data;
        } else {
            return attrs.recipes.data.filter((r) => {
                return r.categories.map((i) => i.slug).some((slug) => state.selectedCategories.includes(slug));
            })
        }
    });

    function toggleCategory(slug) {
        if (! state.selectedCategories.includes(slug)) {
            state.selectedCategories = [...state.selectedCategories, slug]
            return;
        }

        const i = state.selectedCategories.indexOf(slug);
        state.selectedCategories.splice(i, 1);
    }
</script>

<template>
    <Head
        title="All Recipes"
    />

    <BreezeAuthenticatedLayout>
        <AddRecipeTool></AddRecipeTool>

        <CategorySelector
            :categories="$attrs.categories.data"
            :selectedCategories="state.selectedCategories"
            @toggleCategory="toggleCategory"
        ></CategorySelector>

        <div
            class="pb-12"
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
                        <div
                            v-for="(recipe, index) in recipes"
                            v-bind:key="index"
                            class="w-100 sm:w-4/12 md:w-3/12"
                        >
                            <RecipeCard
                                :recipe="recipe"
                            ></RecipeCard>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
