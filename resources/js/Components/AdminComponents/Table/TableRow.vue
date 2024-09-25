<script setup>
import TableDataCell from "@/Components/AdminComponents/Table/TableDataCell.vue";

defineProps({
    contents: {
        type: [String, Array]
    },
    narrow: {
        type: [String, Boolean]
    }
})
</script>
<template>
    <tr class="">
        <TableDataCell v-for="(content, index) in contents" :class="(narrow && (index === 0))?'w-16':''">
            {{ content }}
        </TableDataCell>
        <slot/>
    </tr>
</template>

<style scoped></style>
