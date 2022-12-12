
<script setup>
    import { Link } from '@inertiajs/inertia-vue3';
    import { formatTime } from '../../util/helpers'
    import Button from '../Button.vue';
    import Checkbox from '../Checkbox.vue';
    import DropdownLink from '../DropdownLink.vue';
    import Input from '../Input.vue';
    import Label from '../Label.vue';
    import PlusIcon from '../Icons/Plus.vue';
    import { useForm } from '@inertiajs/inertia-vue3';
    import { ref, reactive } from 'vue';

    const emit = defineEmits(['added:category', 'removed:category']);

    const props = defineProps({
        userCategories: {
            type: Array,
            required: true,
            default: []
        },
        recipeCategories: {
            type: Array,
            required: true,
            default: [],
        }
    });

    const form = useForm({
        category: null,
    })

    const menuVisible = ref(false);

    const categoryInputVisible = ref(false);

    function toggleCategorySelection(slug) {
        if (props.recipeCategories.includes(slug)) {
            emit("removed:category", slug);
        } else {
            emit("added:category", slug);
        }
    }

    function toggleMenuVisiblity() {
        menuVisible.value = !menuVisible.value;
    };

    function toggleCategoryInputVisibility(e) {
        e.preventDefault();
        categoryInputVisible.value = !categoryInputVisible.value;
    }

    function createCategory(e) {
        e.preventDefault();
        form.post('/categories/store', {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => form.reset('category'),
        });
        categoryInputVisible.value = false;
    }

    function updateNewCategoryName(value) {
        newCategoryName.value = value;
    }

</script>

<template>
    <div>
        <Button
            class="mt-4"
            id="dropdownSearchButton"
            data-bs-toggle="dropdownSearch"
            type="button"
            @click="toggleMenuVisiblity()"
        >
            Add Categories
            <svg
                class="ml-2 w-4 h-4"
                aria-hidden="true"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 9l-7 7-7-7"
                ></path>
            </svg>
        </Button>

        <!-- Dropdown menu -->
        <div
            id="dropdownSearch"
            class="z-10 w-100 bg-white rounded shadow dark:bg-gray-700 mt-2"
            :class="menuVisible ? '' : 'hidden'"
        >
            <div
                class="p-3"
            >
                <label
                    for="input-group-search"
                    class="sr-only"
                >
                    Search
                </label>
                <div
                    class="relative"
                >
                    <div
                        class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none"
                    >
                        <svg
                            class="w-5 h-5 text-gray-500 dark:text-gray-400"
                            aria-hidden="true"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd"
                            ></path>
                        </svg>
                    </div>
                    <input
                        type="text"
                        id="input-group-search"
                        class="text-sm rounded-lg block w-full pl-10 p-2.5  bg-gray-50 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        placeholder="Search categories">
                </div>
            </div>

            <div
                class="overflow-y-auto px-3 pb-3 h-48 text-sm text-gray-700 dark:text-gray-200"
                aria-labelledby="dropdownSearchButton"
            >
                <div
                    v-for="(category, index) in userCategories"
                    v-bind:key="index"
                >
                    <div
                        class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600"
                    >
                        <Checkbox
                            :id="`checkbox-item-${index}`"
                            :name="category.slug"
                            :checked="recipeCategories.includes(category.slug)"
                            @update:checked="toggleCategorySelection"
                        ></Checkbox>
                        <Label
                            :for="`checkbox-item-${index}`"
                            class="ml-2 w-full text-sm font-medium text-gray-900 rounded dark:text-gray-300"
                        >
                            {{ category.name }}
                        </Label>
                    </div>
                </div>
                <hr
                    class="h-0 my-2 border border-solid border-t-0 border-gray-700 opacity-25"
                />
                <div
                    v-if="!categoryInputVisible"
                    class="flex block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                    @click="toggleCategoryInputVisibility"
                >
                    <PlusIcon class="mr-2"></PlusIcon>
                    <p>Create new category</p>
                </div>
                <div
                    class="m-2 pt-2"
                    v-if="categoryInputVisible"
                >
                    <form class="flex" @submit.prevent="submit">
                        <Input
                            v-model="form.category"
                            @keydown.enter="createCategory"
                            placeholder="Enter the category name"
                            autofocus
                        ></Input>
                        <Button
                            @click="createCategory"
                            type="button"
                            class="ml-3"
                        >
                            <PlusIcon
                                class="mr-2 fill-white"
                            ></PlusIcon>
                            Add
                        </Button>
                    </form>
                    <div class="mt-1 text-sm text-red-400" v-if="form.errors.category">{{ form.errors.category }}</div>
                </div>
            </div>
        </div>
    </div>
</template>
