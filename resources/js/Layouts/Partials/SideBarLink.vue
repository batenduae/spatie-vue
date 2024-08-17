<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'bg-gradient-to-r from-sky-600 to-cyan-400 text-white'
        : 'text-gray-600 dark:text-gray-300'
);
</script>

<template>
    <Link :href="href"
          class="group rounded-xl px-4 py-3 flex items-center space-x-4 hover:bg-gradient-to-r hover:from-purple-400 hover:to-purple-200"
          :class="classes">
        <slot />
    </Link>
</template>
