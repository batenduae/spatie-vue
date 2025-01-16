<script setup>
import Table from "@/Components/AdminComponents/Table/Table.vue";
import TableRow from "@/Components/AdminComponents/Table/TableRow.vue";
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import TableHeaderRow from "@/Components/AdminComponents/Table/TableHeaderRow.vue";
import TableDataCell from "@/Components/AdminComponents/Table/TableDataCell.vue";
import {usePermissions} from "@/composables/permissions.js";

const {hasPermission, hasPermissionSelf, hasPermissionOthers, hasRole, showFlash} = usePermissions();
defineProps(["roles"]);
</script>

<template>
    <div v-if="hasPermission('roles.index')" class="" >
        <div v-if="roles.length" class="mx-auto">
            <Table>
                <template #caption>
                    Table: Role's Index
                </template>
                <template #tableHeader>
                    <TableHeaderRow :contents="['ID','Name','Group','Description','Action']"/>
                </template>
                <TableRow
                    v-for="role in roles"
                    :key="role.id"
                    :contents="[ role.id,role.name,role.group,role.description]"
                    narrow="narrower"
                >
                    <TableDataCell>
                        <AdminButton
                            v-if="hasPermission(['roles.sync.permission'])"
                            :obj="role"
                            button-text="sync-permit"
                            button-type="assign"
                            route-name="roles.syncPermissionView"
                        />
                        <AdminButton
                            v-if="hasPermission('roles.edit')"
                            :obj="role"
                            button-text="Edit"
                            button-type="edit"
                            route-name="roles.edit"
                        />
                        <AdminButton
                            v-if="hasPermission('roles.delete')"
                            :obj="role"
                            button-text="Delete"
                            button-type="deleteOnConfirm"
                            route-method="delete"
                            route-name="roles.destroy"
                            text="Role"
                        />
                    </TableDataCell>
                </TableRow>
            </Table>
        </div>
        <div v-else class="">
            <div
                class="text-xl text-white bg-gradient-to-br from-pink-300 to-rose-600 rounded-lg p-4 max-w-xl text-center mx-auto">
                No Role Found
            </div>
        </div>
    </div>
    <div v-else class="">
        <div
            class="text-xl text-white bg-gradient-to-br from-pink-300 to-rose-600 rounded-lg p-4 max-w-xl text-center mx-auto">
            You are not allowed to access Role Datatable
        </div>
    </div>

</template>

<style scoped>

</style>
