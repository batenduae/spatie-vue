<script setup>
defineProps({
    narrow: {
        type: [String, Boolean]
    }
})
</script>

<template>
    <th :class="narrow?'w-16':''"
        class="px-4 py-3 items-center text-center align-middle space-x-2 border border-slate-300 dark:border-slate-600">
        <slot/>
    </th>
</template>

<style scoped></style>
