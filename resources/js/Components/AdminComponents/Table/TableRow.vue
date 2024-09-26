<script setup>
import TableDataCell from "@/Components/AdminComponents/Table/TableDataCell.vue";

const props = defineProps({
    contents: {
        type: [String, Array]
    },
    narrow: {
        type: [String, Boolean]
    },
})
</script>
<template>
    <tr class="">
        <template v-for="(content, index) in contents">
            <TableDataCell v-if="narrow && (index === 0)" :narrow>
                {{ content }}
            </TableDataCell>
            <TableDataCell v-else>
                {{ content }}
            </TableDataCell>
        </template>
        <slot/>
    </tr>
</template>

<style scoped></style>
