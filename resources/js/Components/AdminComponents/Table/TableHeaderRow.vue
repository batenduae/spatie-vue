<script setup>
defineProps({
    contents: {
        type: [String,Array]
    }
})
</script>

<template>
    <tr class="rounded-lg">
        <th class="px-6 py-3" v-for="content in contents">
            {{ content }}
        </th>
        <slot />
    </tr>
</template>

<style scoped></style>
