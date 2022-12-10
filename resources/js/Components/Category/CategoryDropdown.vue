
<script setup>
    import { Link } from '@inertiajs/inertia-vue3';
    import { formatTime } from '../../util/helpers'
    import Button from '../Button.vue';
    import Checkbox from '../Checkbox.vue';
    import Label from '../Label.vue';

    import { ref, reactive } from 'vue';

    const emit = defineEmits(['updated:categories']);

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

    const menuVisible = ref(false);

    const selectedCategories = reactive(props.recipeCategories);

    function toggleCategorySelection(slug) {
        if (selectedCategories.includes(slug)) {
            const index = selectedCategories.indexOf(slug);
            selectedCategories.splice(index, 1);
            emit("updated:categories", selectedCategories);
        } else {
            selectedCategories.push(slug);
            emit("updated:categories", selectedCategories);
        }
    }

    function toggleMenuVisiblity() {
        menuVisible.value = !menuVisible.value;
    };

</script>

<template>
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
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Search categories">
            </div>
        </div>

        <ul
            class="overflow-y-auto px-3 pb-3 h-48 text-sm text-gray-700 dark:text-gray-200"
            aria-labelledby="dropdownSearchButton"
        >
            <li
                v-for="(category, index) in userCategories"
                v-bind:key="index"
            >
                <div
                    class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600"
                >
                    <Checkbox
                        :id="`checkbox-item-${index}`"
                        :name="category.slug"
                        :checked="selectedCategories.includes(category.slug)"
                        @update:checked="toggleCategorySelection"
                    ></Checkbox>
                    <Label
                        :for="`checkbox-item-${index}`"
                        class="ml-2 w-full text-sm font-medium text-gray-900 rounded dark:text-gray-300"
                    >
                        {{ category.name }}
                    </Label>
                </div>
            </li>
        </ul>
    </div>
</template>
