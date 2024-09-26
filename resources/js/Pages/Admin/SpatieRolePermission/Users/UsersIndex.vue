<script setup>
import Table from "@/Components/AdminComponents/Table/Table.vue";
import TableRow from "@/Components/AdminComponents/Table/TableRow.vue";
import TableDataCell from "@/Components/AdminComponents/Table/TableDataCell.vue";
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import PageHeader from "@/Components/AdminComponents/Heading/PageHeader.vue";
import TableHeaderRow from "@/Components/AdminComponents/Table/TableHeaderRow.vue";
import SpatieAdminLayout from "@/Layouts/SpatieAdminLayout.vue";
import {onMounted, onUpdated} from "vue";
import {usePermissions} from "@/composables/permissions.js";
import {usePage} from "@inertiajs/vue3";
import TestComponent from "@/Pages/PrimeVue/TestComponent.vue";

const {hasPermission, hasRole, showFlash} = usePermissions();
onMounted(showFlash)
onUpdated(showFlash)
defineProps(["users"]);
defineOptions({layout: SpatieAdminLayout});
</script>

<template>
    <div class="">
        <PageHeader text="Users Index Page" title="Users">
            <AdminButton
                v-if="hasPermission('user.create')"
                button-text="Create User"
                button-type="create"
                route-name="users.create"
            />
        </PageHeader>
        <div
            class="bg-white text-black dark:bg-black dark:text-white px-4 py-3 rounded-lg mb-4 shadow-lg shadow-blue-900 drop-shadow">
            <TestComponent :users="users">
            </TestComponent>
        </div>
        <div v-if="users.length" class="mx-auto">
            <div class="">
                <Table>
                    <template #caption>
                        Table: User's Index Table
                    </template>
                    <template #tableHeader>
                        <TableHeaderRow
                            :contents="['ID','Name','Email','Status','Roles','Permissions Via Role','Direct Permissions','All Permissions','Action']"
                        />
                    </template>
                    <TableRow
                        v-for="user in users"
                        :key="user.id"
                        :contents="[ user.id,user.name,user.email]"
                        narrow="narrower"
                    >
                        <TableDataCell narrow="narrower">
                            <ul v-if="user.status.length" class="flex justify-center justify-items-center space-x-2">
                                <li
                                    v-for="item in user.status"
                                    :class="[
                                    'text-center px-2 rounded-lg text-xs font-bold bg-gradient-to-br',
                                    (item === 'restricted' || item === 'banned') ? 'from-red-500 to-fuchsia-500' : item === 'panel'  ? 'from-green-500 to-indigo-500' : 'from-teal-500 to-fuchsia-500',
                                    ]"
                                >
                                    {{ item }}
                                </li>
                            </ul>
                            <ul v-else>--</ul>
                        </TableDataCell>
                        <TableDataCell>
                            <ul v-if="user.assignedRoles.length"
                                class="flex justify-center justify-items-center space-x-2">
                                <li
                                    v-for="role in user.assignedRoles"
                                    class="text-center px-2 rounded-lg text-xs  font-bold bg-gradient-to-br from-teal-500 to-fuchsia-500"
                                >
                                    {{ role.name }}

                                </li>
                            </ul>
                            <ul v-else>--</ul>
                        </TableDataCell>
                        <TableDataCell narrow="narrower">
                            {{ user.permissionsViaRole.length }}
                        </TableDataCell>
                        <TableDataCell narrow="narrower">
                            {{ user.permissionsDirect.length }}
                        </TableDataCell>
                        <TableDataCell narrow="narrower">
                            {{ user.assignedPermissions.length }}
                        </TableDataCell>
                        <TableDataCell>
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
                                v-if="user.id!==1 && ((usePage().props.auth.user.id !== user.id && hasPermission('delete.otherUser'))||(usePage().props.auth.user.id === user.id && hasPermission('user.delete')))"
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
            <div
                class="text-xl bg-gradient-to-br from-pink-300 to-rose-600 rounded-lg p-4 max-w-xl text-center mx-auto">
                No User Found
            </div>
        </div>
    </div>
</template>

<style scoped></style>
