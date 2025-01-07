<script setup>
import Table from "@/Components/AdminComponents/Table/Table.vue";
import TableDataCell from "@/Components/AdminComponents/Table/TableDataCell.vue";
import TableRow from "@/Components/AdminComponents/Table/TableRow.vue";
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import PageHeader from "@/Components/AdminComponents/Heading/PageHeader.vue";
import TableHeaderRow from "@/Components/AdminComponents/Table/TableHeaderRow.vue";
import {usePermissions} from "@/composables/permissions.js";
import {onMounted, onUpdated} from "vue";
import SpatieAdminLayout from "@/Layouts/SpatieAdminLayout.vue";
import PermissionsDataTable from "@/Components/AdminComponents/DataTable/Primevue/PermissionsDataTable.vue";

const props = defineProps({
    permissions: {
        type: [Object, String],
        required: true
    }
});
const {hasPermission, showFlash} = usePermissions();
onMounted(showFlash)
onUpdated(showFlash)
defineOptions({ layout: SpatieAdminLayout });

</script>

<template>
    <PermissionsDataTable :permissions="permissions"/>
    <div v-if="hasPermission('permissions.index')" class="">
        <PageHeader text="Permissions Index Page" title="Permissions">
            <AdminButton
                button-text="Create Permission"
                button-type="create"
                route-name="permissions.create"
                v-if="hasPermission('permissions.create')"
            />
        </PageHeader>
        <div class="mx-auto" v-if="permissions.length">
            <Table>
                <template #caption>
                    Table: Permissions Index
                </template>
                <template #tableHeader>
                    <TableHeaderRow :contents="['ID','Name','Group','Action']"/>
                </template>
                <TableRow
                    v-for="permission in props.permissions"
                    :key="permission.id"
                    :contents="[ permission.id,permission.name, permission.group]"
                    narrow="narrower"
                >
                    <TableDataCell>
                        <AdminButton
                            button-text="Edit"
                            button-type="edit"
                            route-name="permissions.edit"
                            :obj="permission"
                            v-if="hasPermission('permissions.edit')"
                        />
                        <AdminButton
                            button-text="Delete"
                            button-type="deleteOnConfirm"
                            route-method="delete"
                            route-name="permissions.destroy"
                            :obj="permission"
                            text="Permission"
                            v-if="hasPermission('permissions.delete')"
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
