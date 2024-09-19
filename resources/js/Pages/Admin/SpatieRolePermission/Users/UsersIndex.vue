<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Table from "@/Components/AdminComponents/Table/Table.vue";
import TableRow from "@/Components/AdminComponents/Table/TableRow.vue";
import TableDataCell from "@/Components/AdminComponents/Table/TableDataCell.vue";
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import PageHeader from "@/Components/AdminComponents/Heading/PageHeader.vue";
import TableHeaderRow from "@/Components/AdminComponents/Table/TableHeaderRow.vue";
import {usePermissions} from "@/composables/permissions.js";
import {onMounted} from "vue";
import SpatieAdminLayout from "@/Layouts/SpatieAdminLayout.vue";
const { hasPermission,showFlash } = usePermissions();
onMounted(showFlash)
defineProps(["users"]);
defineOptions({ layout: SpatieAdminLayout });
</script>

<template>
    <PageHeader text="Users Index Page" title="Users">
        <AdminButton
            button-text="Create User"
            button-type="create"
            route-name="users.create"
            v-if="hasPermission('user.create')"
        />
    </PageHeader>
    <div class="mx-auto" v-if="users.length">
        <div class="">
            <Table>
                <template #tableHeader>
                    <TableHeaderRow :contents="['ID','Name','Email','Roles','Direct Permissions','All Permissions','Action']"/>
                </template>
                <TableRow
                    v-for="user in users"
                    :key="user.id"
                    :contents="[ user.id,user.name,user.email]"
                >
                    <TableDataCell class="items-center flex align-middle space-x-2">
                        <ul>{{ user.roles.length}}</ul>
                        <ul class="flex">
                            <li
                                v-for="role in user.roles"
                                class="mr-2 text-center px-2 rounded-lg text-xs text-black font-bold bg-gradient-to-br from-blue-400 to-green-200 mb-2"
                            >
                                {{ role.name }}
                            </li>
                        </ul>
                    </TableDataCell>
                    <TableDataCell>{{ user.permissions.length }}</TableDataCell>
                    <TableDataCell>{{ user.permissionsAll.length}}</TableDataCell>
                    <TableDataCell class="flex space-x-2 items-center">
                        <AdminButton
                            button-text="Assign-Role-Permit"
                            button-type="assign"
                            route-name="users.assignRolePermissionToUser"
                            :obj="user"
                            v-if="hasPermission(['assign-role.to-user','assign-permission.to-user'])"
                        />
                        <AdminButton
                            button-text="Edit"
                            button-type="edit"
                            route-name="users.edit"
                            :obj="user"
                            v-if="hasPermission('user.edit')"
                        />
                        <AdminButton
                            button-text="Delete"
                            button-type="deleteOnConfirm"
                            route-method="delete"
                            route-name="users.destroy"
                            :obj="user"
                            text="User"
                            v-if="hasPermission('user.delete')"
                        />
                        <AdminButton
                            button-text="Log in"
                            button-type="login"
                            route-method="post"
                            route-name="users.loginDynamically"
                            :obj="user"
                            v-if="hasPermission('log-in.dynamically')"
                        />
                    </TableDataCell>
                </TableRow>
            </Table>
        </div>
    </div>
    <div class="" v-else>
        <div class="text-xl text-white bg-gradient-to-br from-pink-300 to-rose-600 rounded-lg p-4 max-w-xl text-center mx-auto">
            No User Found
        </div>
    </div>
</template>

<style scoped></style>
