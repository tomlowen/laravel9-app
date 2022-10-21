<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import { ref, useAttrs } from 'vue'
    import { Inertia } from '@inertiajs/inertia'
    import { formatTime } from '../../util/helpers'
    import ChevronLeft from '../../Components/Icons/ChevronLeft.vue'
    import Options from '../../Components/Icons/Options.vue'
    import Dropdown from '../../Components/Dropdown.vue'
    import DropdownLink from '../../Components/DropdownLink.vue'

    const attrs = useAttrs();
    const quantity = ref(attrs.recipe.data.yield);
    const ingredients = ref(attrs.recipe.data.ingredients);
    const activeTab = ref('tab-1');

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

</script>

<template>
    <Head :title="$attrs.recipe.data.name" />

    <div
        class="absolute"
    >
        <div
            class="w-full"
        >
            <!-- Top buttons -->
            <div
                class="h-80 flex justify-between w-full relative"
            >
                <Link
                    href="/recipes"
                    class="h-10 w-10 z-50 sticky left-3 top-3 mb-3"
                >
                    <ChevronLeft
                        class="leading-4 rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                    ></ChevronLeft>
                </Link>

                <div
                    class="h-10 w-10 z-50 rounded-full sticky right-3 top-3 mb-3"
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
                                    <Options></Options>
                                </button>
                            </span>
                        </template>

                        <template #content>
                            <DropdownLink
                                :href="'/recipes/' + $attrs.recipe.data.id"
                                as="button"
                            >
                                <p>Share</p>
                            </DropdownLink>

                            <DropdownLink
                                :href="`/recipes/${$attrs.recipe.data.id}/edit/`"
                                as="button"
                            >
                                <p>Edit</p>
                            </DropdownLink>

                            <DropdownLink
                                :href="`/recipes/${$attrs.recipe.data.id}`"
                                method="delete"
                                as="button"
                            >
                                <p>Delete</p>
                            </DropdownLink>
                        </template>
                    </Dropdown>
                </div>
            </div>

            <div class="z-40">
                <img
                    :src="'/storage/' + $attrs.recipe.data.images[0].filename"
                    :alt="$attrs.recipe.data.name"
                    class="w-full fixed top-0"
                />
            </div>
        </div>

        <div
            class="z-50 m-auto relative max-w-7xl mx-auto sm:px-6 lg:px-8 "
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

                    <div
                        class="pt-8 w-11/12 flex flex-col items-center"
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
                                >
                                    Ingredients
                                </button>

                                <button
                                    id="tab-2"
                                    type="button"
                                    class="w-1/3 inline-block px-3 py-2.5 text-black font-bold text-sm leading-tight transition duration-150 ease-in-out"
                                >
                                    Steps
                                </button>

                                <button
                                    id="tab-3"
                                    type="button"
                                    class="w-1/3 rounded-r inline-block px-3 py-2.5 text-black font-bold text-sm leading-tight transition duration-150 ease-in-out"
                                >
                                    More info
                                </button>
                            </div>
                        </div>

                        <!-- Tab content -->
                        <div id="tab-content" class="w-11/12 border-solid border-2 border-neutral-200 rounded-xl">
                            <div id="ingredientsTab" class="p-6">
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

                            <!-- <div id="stepsTab">
                                <div
                                    v-for="(step, index) in attrs.recipe.steps"
                                    v-bind:key="index"
                                    class="flex justify-between pt-2 font-semibold"
                                >
                                    <div>
                                        <p>
                                            {{ index + 1 }}
                                        </p>
                                    </div>
                                    <div>
                                        <p>
                                            {{ step.text }}
                                        </p>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
