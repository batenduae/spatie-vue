<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Table from "@/Components/AdminComponents/Table/Table.vue";
import TableDataCell from "@/Components/AdminComponents/Table/TableDataCell.vue";
import TableRow from "@/Components/AdminComponents/Table/TableRow.vue";
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import PageHeader from "@/Components/AdminComponents/Heading/PageHeader.vue";
import TableHeaderRow from "@/Components/AdminComponents/Table/TableHeaderRow.vue";
import {usePermissions} from "@/composables/permissions.js";
import {onMounted} from "vue";
const props = defineProps({
    permissions: {
        type: [Object,String],
        required: true
    }
});
const { hasPermission,showFlash } = usePermissions();
onMounted(showFlash)
defineOptions({ layout: AdminLayout });

</script>

<template>
    <div class="" v-if="hasPermission('permission.view')">
        <PageHeader text="Permissions Index Page" title="Permissions">
            <AdminButton
                button-text="Create Permission"
                button-type="create"
                route-name="permissions.create"
                v-if="hasPermission('permission.create')"
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
                            v-if="hasPermission('permission.edit')"
                        />
                        <AdminButton
                            button-text="Delete"
                            button-type="deleteOnConfirm"
                            route-method="delete"
                            route-name="permissions.destroy"
                            :obj="permission"
                            text="Permission"
                            v-if="hasPermission('permission.delete')"
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
    </div>
</template>

<style scoped></style>
