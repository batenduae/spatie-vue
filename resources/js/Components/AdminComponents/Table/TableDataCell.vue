<script setup>
defineProps({
    narrow: {
        type: [String, Boolean]
    }
})
</script>

<template>
    <td :class="narrow?'w-16':''"
        class="px-4 py-3 items-center text-center align-middle space-x-2 border border-slate-300 dark:border-slate-600 transition ease-in-out duration-300">
        <slot/>
    </td>
</template>

<style scoped></style>
