<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import { ref, useAttrs } from 'vue'
    import { Inertia } from '@inertiajs/inertia'
    import { formatTime } from '../../util/helpers'

    const attrs = useAttrs();
    const quantity = ref(attrs.recipe.yield);
    const ingredients = ref(attrs.recipe.recipe_ingredients);

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
    <Head :title="$attrs.recipe.name" />

    <div class="absolute">
        <div
            class="z-40 relative"
        >
            <img
                :src="'/storage/' + $attrs.recipe.images[0].filename"
                :alt="$attrs.recipe.name"
                class="w-full fixed"
            />
        </div>

        <div
            class="z-50 m-auto relative top-96 max-w-7xl mx-auto sm:px-6 lg:px-8 "
        >
            <div
                class="bg-gradient-to-tr bg-white overflow-hidden shadow-sm rounded-3xl"
            >
                <div
                    class="p-6 border-b border-gray-200 flex flex-col items-center"
                >
                    <h1
                        class="w-3/4 uppercase font-serif font-extrabold text-2xl text-center"
                    >
                        {{ $attrs.recipe.name }}
                    </h1>

                    <p
                        class="pt-2 w-11/12 font-bold text-sm text-center text-slate-400"
                    >
                        {{ $attrs.recipe.description }}
                    </p>

                    <p
                        class="pt-3 pb-5 font-extrabold text-sm text-center"
                    >
                        {{ formatTime($attrs.recipe.total_time) }} | SERVES {{ quantity }}
                    </p>

                    <!-- Quantity adjustment -->
                    <div
                        class="font-extrabold text-base text-center w-10/12 p-3 bg-neutral-200 border-b border-gray-200 flex flex-col items-center rounded-3xl opacity-90"
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
                        class="pt-5"
                    >
                        <div
                            v-for="(ingredient, index) in ingredients"
                            v-bind:key="index"
                        >
                            <p>
                                {{ ingredient.name }} ....... {{ ingredient.quantity }} {{ ingredient.unit }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
