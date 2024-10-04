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

defineProps(["roles"]);
const { hasPermission,showFlash } = usePermissions();
onMounted(showFlash)
onUpdated(showFlash)
defineOptions({ layout: SpatieAdminLayout });

</script>

<template>
    <div v-if="hasPermission('roles.index')" class="">
        <PageHeader text="Roles Index Page" title="Roles">
            <AdminButton
                v-if="hasPermission(['roles.sync.mass-permission'])"
                button-type="create"
                button-text="Sync Mass Permission To Role"
                route-name="roles.syncMassPermissionView"
            />
            <AdminButton
                button-text="Create Role"
                button-type="create"
                route-name="roles.create"
                v-if="hasPermission('roles.create')"
            />
        </PageHeader>

        <div class="mx-auto" v-if="roles.length">
            <Table>
                <template #caption>
                    Table: Role's Index
                </template>
                <template #tableHeader>
                    <TableHeaderRow :contents="['ID','Name','Action']"/>
                </template>
                <TableRow
                    v-for="role in roles"
                    :key="role.id"
                    :contents="[ role.id,role.name]"
                    narrow="narrower"
                >
                    <TableDataCell>
                        <AdminButton
                            v-if="hasPermission(['roles.sync.permission'])"
                            button-type="assign"
                            button-text="sync-permit"
                            :obj="role"
                            route-name="roles.syncPermissionView"
                        />
                        <AdminButton
                            button-text="Edit"
                            button-type="edit"
                            route-name="roles.edit"
                            :obj="role"
                            v-if="hasPermission('roles.edit')"
                        />
                        <AdminButton
                            button-text="Delete"
                            button-type="deleteOnConfirm"
                            route-method="delete"
                            route-name="roles.destroy"
                            :obj="role"
                            text="Role"
                            v-if="hasPermission('roles.delete')"
                        />
                    </TableDataCell>
                </TableRow>
            </Table>
        </div>
        <div class="" v-else>
            <div class="text-xl text-white bg-gradient-to-br from-pink-300 to-rose-600 rounded-lg p-4 max-w-xl text-center mx-auto">
                No Role Found
            </div>
        </div>
    </div>
</template>

<style scoped></style>
