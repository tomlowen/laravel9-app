<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import {computed} from "vue";
import { formatTime } from '../../util/helpers'

const props = defineProps({
  recipe: Object,
})

const imageSrc = computed(()=>props.recipe.images[0].filename)

</script>

<template>
    <Link
        :href="'/recipes/' + recipe.id"
    >
        <div class="m-2 flex flex-col align-middle justify-center">
            <div
                class="rounded-t-xl h-48 bg-center bg-cover"
                :style="{ backgroundImage: `url(${'/storage/' + imageSrc})` }"
            ></div>
                <div
                    class="font-extrabold text-base text-center w-full p-3 bg-neutral-200 border-b border-neutral-200 flex flex-col self-center items-center rounded-b-xl opacity-90"
                >
                    <h1
                        class="w-3/4 uppercase font-serif font-extrabold text-center"
                    >
                        {{ recipe.name }}
                    </h1>
                    <p
                        class="font-extrabold text-xs text-center"
                    >
                        {{ formatTime(recipe.totalTime) }} | EASY
                    </p>
                <div/>
            </div>
        </div>
    </Link>
</template>
