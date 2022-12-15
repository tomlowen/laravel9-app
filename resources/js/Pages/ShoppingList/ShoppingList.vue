<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { useAttrs, ref, reactive, computed, watch } from 'vue';
    import { Head } from '@inertiajs/inertia-vue3';
    import { Inertia } from '@inertiajs/inertia';
    import AddToShoppingListModal from '../../Components/ShopplingList/AddToShoppingListModal.vue';
    import Button from '../../Components/Button.vue';
    import DeleteIcon from '../../Components/Icons/Delete.vue';
    import EditIcon from '../../Components/Icons/Edit.vue';
    import ShareIcon from '../../Components/Icons/Share.vue';
    import OptionsIcon from '../../Components/Icons/Options.vue';
    import Checkbox from '../../Components/Checkbox.vue';
    import Dropdown from '../../Components/Dropdown.vue';
    import DropdownLink from '../../Components/DropdownLink.vue';
    import Chevron from '../../Components/Icons/ChevronLeft.vue';
    import DeleteListModal from '../../Components/DeleteModal.vue'

    const attrs = useAttrs();
    const isEditing = ref(false);
    const modalVisible = ref(false);

    const categories = computed(() => attrs.ingredients
        ? [...new Map(attrs.ingredients.data.map(item => [item['category']['slug'], item['category']])).values()]
        : []);

    const visibleDropdowns = reactive(categories ? categories.value.map(c => c.id) : []);
    const ingredients = reactive(computed(() => attrs.ingredients ? attrs.ingredients.data : []));

    function toggleDropdown(categoryId) {
        if (visibleDropdowns.includes(categoryId)) {
            visibleDropdowns.splice(visibleDropdowns.indexOf(categoryId), 1)
        } else {
            visibleDropdowns.push(categoryId);
        }
    };

    function deleteIngredient(id) {
        Inertia.delete(`shopping-list/${id}`, {
            preserveState: true,
            preserveScroll: true,
            only: ['ingredients'],
        });
    }

    function updateIngredient(ingredient) {
        Inertia.put(`shopping-list/${ingredient.id}/update`, {
            shoppingListIngredient: ingredient,
            preserveState: true,
            preserveScroll: true,
            only: ['ingredients'],
        });
    }

    function toggleEditingMode() {
        isEditing.value = !isEditing.value;
    }

    function toggleModal() {
        modalVisible.value = !modalVisible.value;
    }

    function share() {
        // console.log(navigator.share);
        // navigator.share({
        //     title: 'WebShare API Demo',
        //     url: 'https://codepen.io/ayoisaiah/pen/YbNazJ'
        // })
    }

</script>

<template>
    <Head
        title="Shopping List"
    />

    <DeleteListModal
        :visible="modalVisible"
        model="list"
        @toggleModal="toggleModal"
    ></DeleteListModal>

    <BreezeAuthenticatedLayout>
        <div
            class="py-12"
        >
        <!-- Top buttons -->
            <div
                class="max-w-7xl mx-auto sm:px-6 lg:px-8 h-10 z-50 rounded-full sticky right-3 top-3 mb-3 flex justify-between"
            >
                <div></div>
                <Dropdown
                    align="right"
                    width="48"
                >
                    <template #trigger>
                        <span
                            class="inline-flex rounded-md mr-3"
                        >
                            <button
                                type="button"
                                class="inline-flex items-center border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                            >
                                <OptionsIcon></OptionsIcon>
                            </button>
                        </span>
                    </template>

                    <template #content>
                        <button
                            class="w-full px-4 py-2 flex align-center text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                            as="button"
                            @click="share"
                        >
                            <ShareIcon class="mr-1"></ShareIcon>
                            <p class="m-1">Share</p>
                        </button>

                        <button
                            class="w-full px-4 py-2 flex align-center text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                            as="button"
                            @click="toggleEditingMode"
                        >
                            <EditIcon class="mr-1"></EditIcon>
                            <p class="m-1">Edit</p>
                        </button>

                        <button
                            class="w-full px-4 py-2 flex align-center text-red-400 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                            as="button"
                            @click="toggleModal"
                        >
                            <DeleteIcon class="mr-1"></DeleteIcon>
                            <p class="m-1">Delete</p>
                        </button>
                    </template>
                </Dropdown>
            </div>

            <div
                class="max-w-7xl mx-auto sm:px-6 lg:px-8"
            >
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div
                        v-for="category in categories"
                        v-bind:key="category.id"
                        class="p-4 bg-white border-b border-gray-200 sm:flex-wrap sm:flex-row grow align-middle"
                    >
                        <div
                            class="dropdown-banner flex"
                            @click="toggleDropdown(category.id)"
                        >
                            <Chevron
                                :class="visibleDropdowns.includes(category.id) ? 'rotate-270' : 'rotate-180'"
                            ></Chevron>
                            <div
                                class="my-2"
                            >
                                {{ category.name }}
                            </div>
                        </div>
                        <div v-if="visibleDropdowns.includes(category.id)" class="dropdown-content">
                            <div
                                v-for="(ingredient, index) in ingredients.filter(i => i.category.id === category.id)"
                                v-bind:key="index"
                                class="flex content-center"
                            >
                                <Checkbox
                                    v-model="ingredient.bought"
                                    class="ml-5 rounded-full h-6 w-6 mt-1"
                                    :name="ingredient.name"
                                    @change="updateIngredient(ingredient)"
                                    :checked="ingredient.bought"
                                ></Checkbox>
                                <div
                                    class="w-5/6 mb-2"
                                >
                                    <div
                                        class="flex justify-between py-1"
                                    >
                                        <p
                                            class="pl-3"
                                        >
                                            {{ `${ingredient.quantity} ${ingredient.unit} ${ingredient.name}` }}
                                        </p>
                                        <Button
                                            v-if="isEditing"
                                            class="px-2 py-0"
                                            @click="deleteIngredient(ingredient.id)"
                                        >
                                            <DeleteIcon
                                                class="w-4 h-4"
                                            ></DeleteIcon>
                                        </Button>
                                    </div>
                                    <hr
                                        v-if="index + 1 != ingredients.filter(i => i.category.id === category.id).length"
                                        class="mt-2"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
