<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import { ref, useAttrs } from 'vue';
    import { Inertia } from '@inertiajs/inertia';
    import { formatTime } from '../../util/helpers';
    import ChevronLeft from '../../Components/Icons/ChevronLeft.vue';
    import OptionsIcon from '../../Components/Icons/Options.vue';
    import EditIcon from '../../Components/Icons/Edit.vue';
    import DeleteIcon from '../../Components/Icons/Delete.vue';
    import ShareIcon from '../../Components/Icons/Share.vue';
    import Dropdown from '../../Components/Dropdown.vue';
    import DeleteRecipeModal from '../../Components/DeleteModal.vue';
    import DropdownLink from '../../Components/DropdownLink.vue';
    import AddToShoppingListButton from '../../Components/ShopplingList/AddToShoppingListButton.vue';

    const attrs = useAttrs();
    const quantity = ref(attrs.recipe.data.yield);
    const ingredients = ref(attrs.recipe.data.ingredients);
    const activeTab = ref('tab-1');
    const modalVisible = ref(false);

    function increment() {
        quantity.value++;
        ingredients.value.forEach((i) => {
            i.quantity = (i.quantity / (quantity.value -1)) * quantity.value;
        })
    }

    function decrement() {
        quantity.value--;
        ingredients.value.forEach((i) => {
            i.quantity = (i.quantity / (quantity.value +1)) * quantity.value;
        })
    }

    function setActiveTab(tab) {
        activeTab.value = tab;
    }

    function toggleModal() {
        modalVisible.value = !modalVisible.value;
    }

</script>

<template>
    <Head :title="$attrs.recipe.data.name" />

    <DeleteRecipeModal
        :visible="modalVisible"
        :modelId="$attrs.recipe.data.id"
        model="recipe"
        @toggleModal="toggleModal"
    ></DeleteRecipeModal>

        <div
            class="absolute w-full"
        >
            <div
                class="w-full"
            >
                <!-- Top buttons -->
                <div
                    class="h-80 flex justify-between w-full relative m-auto max-w-7xl mx-auto sm:px-6 lg:px-8"
                >
                    <Link
                        href="/recipes"
                        class="h-10 w-10 z-30 sticky left-3 top-3 mb-3"
                    >
                        <ChevronLeft
                            class="leading-4 rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                        ></ChevronLeft>
                    </Link>

                    <div
                        class="h-10 w-10 z-40 rounded-full sticky right-3 top-3 mb-3"
                    >
                        <Dropdown
                            align="right"
                            width="48"
                        >
                            <template #trigger>
                                <span
                                    class="inline-flex rounded-md"
                                >
                                    <button
                                        type="button"
                                        class="inline-flex items-center opacity-90 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                    >
                                        <OptionsIcon></OptionsIcon>
                                    </button>
                                </span>
                            </template>

                            <template #content>
                                <DropdownLink
                                    class="flex align-middle"
                                    :href="'/recipes/' + $attrs.recipe.data.id"
                                    as="button"
                                >
                                    <ShareIcon class="mr-1"></ShareIcon>
                                    <p class="m-1">Share</p>
                                </DropdownLink>

                                <DropdownLink
                                    class="flex align-center"
                                    :href="`/recipes/${$attrs.recipe.data.id}/edit/`"
                                    as="button"
                                >
                                    <EditIcon class="mr-1"></EditIcon>
                                    <p class="m-1">Edit</p>
                                </DropdownLink>

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
                </div>

                <div class="z-20">
                    <img
                        :src="'/storage/' + $attrs.recipe.data.images[0].filename"
                        :alt="$attrs.recipe.data.name"
                        class="w-full fixed top-0"
                    />
                </div>
            </div>

            <div
                class="z-30 m-auto relative max-w-7xl mx-auto sm:px-6 lg:px-8 "
            >
                <div
                    class="bg-gradient-to-tr bg-white overflow-hidden shadow-sm rounded-3xl"
                >
                    <div
                        class="p-6 border-b border-neutral-200 flex flex-col items-center"
                    >
                        <h1
                            class="w-3/4 uppercase font-serif font-extrabold text-2xl text-center"
                        >
                            {{ $attrs.recipe.data.name }}
                        </h1>

                        <p
                            class="pt-2 w-11/12 font-bold text-sm text-center text-slate-400"
                        >
                            {{ $attrs.recipe.data.description }}
                        </p>

                        <p
                            class="pt-3 pb-5 font-extrabold text-sm text-center"
                        >
                            {{ formatTime($attrs.recipe.data.totalTime) }} | SERVES {{ quantity }}
                        </p>

                        <!-- Quantity adjustment -->
                        <div
                            class="font-extrabold text-base text-center w-10/12 p-3 bg-neutral-200 border-b border-neutral-200 flex flex-col items-center rounded-3xl opacity-90"
                        >
                            <p>
                                Quantity
                            </p>

                            <div
                                class="text-xl flex"
                            >
                                <button
                                    @click="decrement"
                                    :disabled="quantity < 2"
                                    :class="quantity < 2 ? 'text-slate-400' : ''"
                                >
                                    -
                                </button>

                                <img
                                    src="@/assets/images/one-bowl.png"
                                    class="h-10 px-5"
                                />

                                <button
                                    @click="increment"
                                >
                                    +
                                </button>
                            </div>
                        </div>

                        <AddToShoppingListButton
                            :recipe="$attrs.recipe.data"
                        ></AddToShoppingListButton>

                        <div
                            class="pt-8 w-11/12 flex flex-col items-center mb-20"
                        >
                            <!-- Tab bar -->
                            <div
                                id="tab-bar"
                                class="flex items-center justify-center w-11/12 md:hidden"
                            >
                                <div
                                    class="inline-flex w-full"
                                    role="group"
                                >
                                    <button
                                        id="tab-1"
                                        type="button"
                                        class="w-1/3 rounded-l inline-block px-3 py-2.5 text-black font-bold text-sm leading-tight transition duration-150 ease-in-out"
                                        @click="setActiveTab('tab-1')"
                                    >
                                        Ingredients
                                    </button>

                                    <button
                                        id="tab-2"
                                        type="button"
                                        class="w-1/3 inline-block px-3 py-2.5 text-black font-bold text-sm leading-tight transition duration-150 ease-in-out"
                                        @click="setActiveTab('tab-2')"
                                    >
                                        Steps
                                    </button>

                                    <button
                                        id="tab-3"
                                        type="button"
                                        class="w-1/3 rounded-r inline-block px-3 py-2.5 text-black font-bold text-sm leading-tight transition duration-150 ease-in-out"
                                        @click="setActiveTab('tab-3')"
                                    >
                                        More info
                                    </button>
                                </div>
                            </div>

                            <!-- Tab content -->
                            <div id="tab-content" class="w-11/12">
                                <div class="md:flex">
                                    <div ref="tab-1" :class="{'mmd:hidden': activeTab !== 'tab-1'}" class="md:mr-2 p-6 border-solid border-2 border-neutral-200 rounded-xl md:w-1/2 lg:w-1/3" >
                                        <div
                                            v-for="(ingredient, index) in $attrs.recipe.data.ingredients"
                                            v-bind:key="index"
                                            class="flex justify-between pt-2 font-semibold"
                                        >
                                            <div>
                                                <p>
                                                    {{ ingredient.name.charAt(0).toUpperCase() + ingredient.name.slice(1) }}
                                                </p>
                                            </div>
                                            <div>
                                                <p>
                                                    {{ ingredient.quantity }} {{ ingredient.unit }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div ref="tab-2" :class="{'mmd:hidden': activeTab !== 'tab-2'}" class="p-6 border-solid border-2 border-neutral-200 rounded-xl md:w-1/2 lg:w-2/3" >
                                        <div
                                            v-for="(step, index) in attrs.recipe.data.steps"
                                            v-bind:key="index"
                                            class="flex pt-2"
                                        >
                                            <div class="mr-2 font-semibold">
                                                <p>
                                                    {{ index + 1 }}
                                                </p>
                                            </div>
                                            <div>
                                                <p>
                                                    {{ step }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div ref="tab-3" :class="{'mmd:hidden': activeTab !== 'tab-3'}" class="md:mt-2 p-6 border-solid border-2 border-neutral-200 rounded-xl" >
                                    <div
                                    > More info
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>
