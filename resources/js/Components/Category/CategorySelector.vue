<script setup>
    import { Link } from '@inertiajs/inertia-vue3';
    import { formatTime } from '../../util/helpers'

    const props = defineProps({
        categories: Object,
        selectedCategories: Array,
    })

</script>

<template>
    <div class="pb-4">
        <div
            class="max-w-7xl overflow-hidden mx-auto sm:px-6 lg:px-8"
        >
            <div
                class="bg-white shadow-sm overflow-x-auto sm:rounded-lg"
            >
                <div
                    class="p-6 bg-white border-b border-gray-200 inline-flex "
                    v-if="selectedCategories"
                >
                    <div
                        v-for="category in categories"
                        v-bind:key="category.slug"
                    >
                        <button>
                            <div
                                class="w-fit bg-gray-200 shadow-sm rounded-full py-2 px-4 mr-4 h-10"
                                :class="selectedCategories.includes(category.slug) ? 'bg-gray-400' : 'bg-gray-200'"
                                @click="$emit('toggleCategory', category.slug)"
                            >
                                <p
                                    class="whitespace-nowrap"
                                >
                                    {{ category.name }}
                                </p>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
