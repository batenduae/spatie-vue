<script setup>
import {Head} from "@inertiajs/vue3";

defineProps({
    text: {
        type: String,
    },
    content: {
        type: String,
    },

    title: {
        type: String,
    }
})
</script>

<template>
    <Head :title/>
    <div class="w-full mx-auto py-4">
        <div class="flex justify-between items-baseline">
            <div class="bg-gradient-to-tr from-cyan-700 to-green-500 px-4 py-2 rounded-lg ">
                <div class="text-black dark:text-white text-xl font-semibold">
                    {{ text }} <span class="font-bold text-indigo-900">{{ content }}</span>
                </div>
            </div>
            <slot></slot>
        </div>
    </div>
</template>

<style scoped>

</style>
