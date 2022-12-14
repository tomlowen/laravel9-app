<script setup>
    import Button from '../../Components/Button.vue';
    import Checkbox from '../../Components/Checkbox.vue';
    import CrossIcon from '../Icons/Cross.vue';

    const props = defineProps({
        modalVisible: {
            type: Boolean,
            required: true,
            default: false,
        },
        ingredients: {
            type: Array,
            required: true,
            default: ['carrot', 'pepper', 'gravy'],
        },
    })

    const emit = defineEmits(['toggled:modal']);

    function emitToggle() {
        emit('toggled:modal');
    }
</script>

<template>
    <!-- Main modal -->
    <div
        v-if="modalVisible"
        id="add-to-shopping-list-modal"
        tabindex="-1"
        aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full"
    >
        <div
            class="relative w-full h-full max-w-md md:h-auto"
        >
            <!-- Modal content -->
            <div
                class="relative bg-white rounded-lg shadow dark:bg-gray-700"
            >
                <button
                    @click="emitToggle"
                    type="button"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                >
                    <CrossIcon></CrossIcon>
                    <span
                        class="sr-only"
                    >
                        Close modal
                    </span>
                </button>
                <div
                    class="px-6 py-6 lg:px-8"
                >
                    <h3
                        class="mb-4 text-xl font-medium text-gray-900 dark:text-white"
                    >
                        Add ingredients to your shopping list
                    </h3>
                    <div
                        action="#"
                    >
                        <div
                            v-for="(ingredient, index) in ingredients"
                            v-bind:key="index"
                            class="flex"
                        >
                            <Checkbox
                                name="ingredient"
                            ></Checkbox>
                            <label
                                for="ingredient"
                                class="pl-3 block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >
                                {{ ingredient }}
                            </label>
                        </div>

                        <Button
                            type="submit"
                            class="w-full focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 mt-2 text-center"
                        >
                            Add ingredients
                        </Button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
