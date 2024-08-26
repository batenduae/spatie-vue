<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Table from "@/Components/AdminComponents/Table/Table.vue";
import TableDataCell from "@/Components/AdminComponents/Table/TableDataCell.vue";
import TableRow from "@/Components/AdminComponents/Table/TableRow.vue";
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import PageHeader from "@/Components/AdminComponents/Heading/PageHeader.vue";
import TableHeaderRow from "@/Components/AdminComponents/Table/TableHeaderRow.vue";

const props = defineProps({
    permissions: {
        type: [Object,String],
        required: true
    }
});
defineOptions({ layout: AdminLayout });
</script>

<template>
    <PageHeader text="Permissions Index Page" title="Permissions">
        <AdminButton
            button-text="Create Permission"
            button-type="create"
            route-method=""
            route-name="permissions.create"
            obj=""
        />
    </PageHeader>
    <div class="mx-auto" v-if="permissions.length">
        <Table>
            <template #tableHeader>
                <TableHeaderRow :contents="['ID','Name','Action']"/>
            </template>
            <TableRow
                v-for="permission in props.permissions"
                :key="permission.id"
                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                :contents="[ permission.id,permission.name]"
            >
                <TableDataCell class="flex space-x-2">
                    <AdminButton
                        button-text="Edit"
                        button-type="edit"
                        route-name="permissions.edit"
                        :obj="permission"
                    />
                    <AdminButton
                        button-text="Delete"
                        button-type="deleteOnConfirm"
                        route-method="delete"
                        route-name="permissions.destroy"
                        :obj="permission"
                        text="Permission"
                    />
                </TableDataCell>
            </TableRow>
        </Table>
    </div>
    <div class="" v-else>
        <div class="text-xl text-white bg-gradient-to-br from-pink-300 to-rose-600 rounded-lg p-4 max-w-xl text-center mx-auto">
            No Permission Found
        </div>
    </div>
</template>

<style scoped></style>
