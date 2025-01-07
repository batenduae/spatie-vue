<script setup>
import Table from "@/Components/AdminComponents/Table/Table.vue";
import TableRow from "@/Components/AdminComponents/Table/TableRow.vue";
import TableDataCell from "@/Components/AdminComponents/Table/TableDataCell.vue";
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import PageHeader from "@/Components/AdminComponents/Heading/PageHeader.vue";
import TableHeaderRow from "@/Components/AdminComponents/Table/TableHeaderRow.vue";
import SpatieAdminLayout from "@/Layouts/SpatieAdminLayout.vue";
import {usePermissions} from "@/composables/permissions.js";
import {onMounted, onUpdated} from "vue";

const {hasPermission, showFlash} = usePermissions();
onMounted(showFlash)
onUpdated(showFlash)
defineProps(["usersProfile"]);
defineOptions({layout: SpatieAdminLayout});
</script>

<template>
    <PageHeader text="User's Profile Index Page" title="User's Profile">
        <AdminButton
            v-if="hasPermission('users.others.create')"
            button-text="Create User's Profile"
            button-type="create"
            route-name="usersProfile.create"
        />
    </PageHeader>
    <div v-if="usersProfile.length" class="mx-auto">
        <div class="">
            <Table>
                <template #tableHeader>
                    <TableHeaderRow
                        :contents="['UserID','Image','Formal Photo','Birthday','Blood Group','Primary Phone','Secondary Phone','Action']"/>
                </template>
                <TableRow
                    v-for="user in users"
                    :key="user.id"
                    :contents="[ user.id,user.name,user.email]"
                >
                    <TableDataCell class="items-center align-middle space-x-2">
                        <ul>{{ user.status.length }}</ul>
                        <ul class="flex">
                            <li
                                v-for="item in user.status"
                                class="mr-2 text-center px-2 rounded-lg text-xs  font-bold bg-gradient-to-br from-teal-500 to-fuchsia-500 mb-2"
                            >
                                {{ item }}
                            </li>
                        </ul>
                    </TableDataCell>
                    <TableDataCell class="items-center align-middle space-x-2">
                        <ul>{{ user.roles.length }}</ul>
                        <ul class="flex">
                            <li
                                v-for="role in user.roles"
                                class="mr-2 text-center px-2 rounded-lg text-xs  font-bold bg-gradient-to-br from-teal-500 to-fuchsia-500 mb-2"
                            >
                                {{ role.name }}
                            </li>
                        </ul>
                    </TableDataCell>
                    <TableDataCell>{{ user.permissions.length }}</TableDataCell>
                    <TableDataCell>{{ user.permissionsAll.length }}</TableDataCell>
                    <TableDataCell class="flex space-x-2 items-center">
                        <AdminButton
                            v-if="hasPermission(['assign-role.to-user','assign-permission.to-user'])"
                            :obj="user"
                            button-text="Assign-Role-Permit"
                            button-type="assign"
                            route-name="users.assignRolePermissionToUser"
                        />
                        <AdminButton
                            v-if="hasPermission('user.edit')"
                            :obj="user"
                            button-text="Edit"
                            button-type="edit"
                            route-name="users.edit"
                        />
                        <AdminButton
                            v-if="hasPermission('user.delete')"
                            :obj="user"
                            button-text="Delete"
                            button-type="deleteOnConfirm"
                            route-method="delete"
                            route-name="users.destroy"
                            text="User"
                        />
                        <AdminButton
                            v-if="hasPermission('log-in.dynamically')"
                            :obj="user"
                            button-text="Log in"
                            button-type="login"
                            route-method="post"
                            route-name="users.loginDynamically"
                        />
                    </TableDataCell>
                </TableRow>
            </Table>
        </div>
    </div>
    <div v-else class="">
        <div class="text-xl bg-gradient-to-br from-pink-300 to-rose-600 rounded-lg p-4 max-w-xl text-center mx-auto">
            No User's Profile Found
        </div>
    </div>
</template>
<style scoped></style>
