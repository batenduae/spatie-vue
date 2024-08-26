<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Table from "@/Components/AdminComponents/Table/Table.vue";
import TableDataCell from "@/Components/AdminComponents/Table/TableDataCell.vue";
import TableHeaderCell from "@/Components/AdminComponents/Table/TableHeaderCell.vue";
import TableRow from "@/Components/AdminComponents/Table/TableRow.vue";
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import PageHeader from "@/Components/AdminComponents/Heading/PageHeader.vue";
import TableHeaderRow from "@/Components/AdminComponents/Table/TableHeaderRow.vue";
defineProps(["roles"]);
defineOptions({ layout: AdminLayout });
</script>

<template>
    <PageHeader text="Roles Index Page" title="Roles">
        <AdminButton
            button-text="Mass Assign Role Permission"
            button-type="create"
            route-name="roles.massAssignPermissionToRole"
        />
        <AdminButton
            button-text="Create Role"
            button-type="create"
            route-name="roles.create"
        />
    </PageHeader>
    <div class="mx-auto" v-if="roles.length">
        <Table>
            <template #tableHeader>
                <TableHeaderRow :contents="['ID','Name','Action']"/>
            </template>
            <TableRow
                v-for="role in roles"
                :key="role.id"
                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                :contents="[ role.id,role.name]"
            >
                <TableDataCell class="flex space-x-2">
                    <AdminButton
                        button-text="Assign-permit"
                        button-type="assign"
                        route-name="roles.assignPermissionToRoleView"
                        :obj="role"
                    />
                    <AdminButton
                        button-text="Edit"
                        button-type="edit"
                        route-name="roles.edit"
                        :obj="role"
                    />
                    <AdminButton
                        button-text="Delete"
                        button-type="deleteOnConfirm"
                        route-method="delete"
                        route-name="roles.destroy"
                        :obj="role"
                        text="Role"
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
</template>

<style scoped></style>
