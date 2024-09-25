<script setup>
import TableHeaderCell from "@/Components/AdminComponents/Table/TableHeaderCell.vue";

defineProps({
    contents: {
        type: [String, Array]
    }
})
</script>

<template>
    <tr class="">
        <TableHeaderCell v-for="content in contents">
            {{ content }}
        </TableHeaderCell>
        <slot/>
    </tr>
</template>

<style scoped></style>
