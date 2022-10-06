<template>
    <Head title="Recipes" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Recipes
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <label for="recipe-url">Enter a URL to import a recipe from:</label>
                            <input id="recipe-url" v-model="form.recipeUrl" />
                            <button type="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'

export default {
    setup () {
        const form = reactive({
            recipeUrl: '',
        })

        function submit() {
            Inertia.post('/import', form)
        }

        return { form, submit }
    },
}
</script>
