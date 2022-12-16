<script setup>
    import Button from '../../Components/Button.vue';
    import Checkbox from '../../Components/Checkbox.vue';
    import CartIcon from '../Icons/CartIcon.vue';
    import { Inertia } from '@inertiajs/inertia';
    import Toast from '../../Components/Toast.vue'

    const props = defineProps({
        recipe: {
            type: Object,
            required: true,
        },
    })

    function AddIngredientsToShoppingList() {
        Inertia.post(
            '/shopping-list/add-ingredients',
            {
                'recipe': props.recipe
            },
            {
                preserveState: true,
                preserveScroll: true,
                resetOnSuccess: false,
            }
        )
    }
</script>

<template>
    <div class="w-10/12 mt-3">
        <Button
            class="w-full flex justify-center"
            @click.prevent="AddIngredientsToShoppingList"
        >
            Add ingredients to shopping list
            <div class="relative h-10 w-10 ml-2">
                <div class="h-10 w-10 rounded-full bg-gray-300 absolute"></div>
                <CartIcon
                    class="top-2 left-1.5 h-7 w-7 fill-gray-800 absolute"
                ></CartIcon>
            </div>
        </Button>
        <Toast v-if="$page.props.toast"></Toast>
    </div>
</template>
