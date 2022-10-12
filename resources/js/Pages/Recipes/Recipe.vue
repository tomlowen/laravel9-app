<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import { ref, useAttrs } from 'vue'
    import { Inertia } from '@inertiajs/inertia'
    import { formatTime } from '../../util/helpers'

    const attrs = useAttrs();
    const quantity = ref(attrs.recipe.yield);

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
                                @click="quantity--"
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
                                @click="quantity++"
                            >
                                +
                            </button>
                        </div>
                    </div>

                    <div>
                        <p
                            v-for="(index, ingredient) in $attrs.recipe.ingredients"
                            v-bind:key="index"
                        >
                            {{ ingredient }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
