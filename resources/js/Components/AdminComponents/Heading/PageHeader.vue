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
    <div class="max-w-7xl mx-auto py-4">
        <div class="flex justify-between items-baseline">
            <div class="bg-gradient-to-tr from-cyan-700 px-4 py-2 rounded-lg ">
                <div class="text-white text-xl">
                    {{ text }} <span class="font-bold text-green-500">{{ content }}</span>
                </div>
            </div>
            <slot></slot>
        </div>
    </div>
</template>

<style scoped>

</style>
