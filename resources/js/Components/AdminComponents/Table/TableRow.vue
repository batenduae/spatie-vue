<script setup>
defineProps({
    contents: {
        type: [String,Array]
    }
})
</script>
<template>
    <tr class="border-b border-slate-300 dark:border-slate-600">
        <td class="px-6 py-3" v-for="content in contents">
            {{ content }}
        </td>
        <slot />
    </tr>
</template>

<style scoped></style>
