<script setup>
import Table from "@/Components/AdminComponents/Table/Table.vue";
import TableRow from "@/Components/AdminComponents/Table/TableRow.vue";
import TableDataCell from "@/Components/AdminComponents/Table/TableDataCell.vue";
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import PageHeader from "@/Components/AdminComponents/Heading/PageHeader.vue";
import TableHeaderRow from "@/Components/AdminComponents/Table/TableHeaderRow.vue";
import SpatieAdminLayout from "@/Layouts/SpatieAdminLayout.vue";
import {usePermissions} from "@/composables/permissions.js";
import {onMounted, onUpdated, ref} from "vue";
import {usePage} from "@inertiajs/vue3";

const authUserId = ref(usePage().props.auth.user.id);
const {hasPermission, hasRole, showFlash} = usePermissions();
onMounted(showFlash)
onUpdated(showFlash)
defineProps(["users"]);
defineOptions({layout: SpatieAdminLayout});

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
                <template #caption>
                    Table: User's Index Table
                </template>
                <template #tableHeader>
                    <TableHeaderRow
                        :contents="['ID','Name','Email','Status','Roles','Direct Permissions','All Permissions','Action']"/>
                </template>
                <TableRow
                    v-for="user in users"
                    :key="user.id"
                    :contents="[ user.id,user.name,user.email]"
                    :narrow=true
                >
                    <TableDataCell>
                        <ul v-if="user.status.length" class="flex justify-center justify-items-center">
                            <li
                                v-for="item in user.status"
                                class="mr-2 text-center px-2 rounded-lg text-xs  font-bold bg-gradient-to-br from-teal-500 to-fuchsia-500 mb-2"
                            >
                                {{ item }}
                            </li>
                        </ul>
                        <ul v-else>--</ul>
                    </TableDataCell>
                    <TableDataCell>
                        <ul v-if="user.roles.length" class="flex">
                            <li
                                v-for="role in user.roles"
                                class="mr-2 text-center px-2 rounded-lg text-xs  font-bold bg-gradient-to-br from-teal-500 to-fuchsia-500 mb-2"
                            >
                                {{ role.name }}

                            </li>
                        </ul>
                        <ul v-else>--</ul>
                    </TableDataCell>
                    <TableDataCell>
                        {{ user.permissions.length }}
                    </TableDataCell>
                    <TableDataCell>
                        {{ user.permissionsAll.length }}
                        {{ hasRole('super admin') }}
                    </TableDataCell>
                    <TableDataCell v-if="(user.id!==1)||(authUserId===1)||hasRole('super admin')">
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
                            v-if="(hasPermission('user.delete')&& (authUserId === user.id))||(hasPermission('delete.otherUser'))"
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
        <div class="text-xl bg-gradient-to-br from-pink-300 to-rose-600 rounded-lg p-4 max-w-xl text-center mx-auto">
            No User Found
        </div>
    </div>
</template>

<style scoped></style>
