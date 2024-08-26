<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Table from "@/Components/AdminComponents/Table/Table.vue";
import TableRow from "@/Components/AdminComponents/Table/TableRow.vue";
import TableDataCell from "@/Components/AdminComponents/Table/TableDataCell.vue";
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import PageHeader from "@/Components/AdminComponents/Heading/PageHeader.vue";
import TableHeaderRow from "@/Components/AdminComponents/Table/TableHeaderRow.vue";
defineProps(["users"]);
defineOptions({ layout: AdminLayout });
</script>

<template>
    <PageHeader text="Users Index Page" title="Users">
        <AdminButton
            button-text="Create User"
            button-type="create"
            route-name="users.create"
        />
    </PageHeader>
    <div class="mx-auto" v-if="users.length">
        <div class="">
            <Table>
                <template #tableHeader>
                    <TableHeaderRow :contents="['ID','Name','Email','Roles','Action']"/>
                </template>
                <TableRow
                    v-for="user in users"
                    :key="user.id"
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                    :contents="[ user.id,user.name,user.email]"
                >
                    <TableDataCell class="items-center">
                        <ul class="flex">
                            <li
                                v-for="role in user.roles"
                                class="mr-2 text-center px-2 rounded-lg text-xs text-black font-bold bg-gradient-to-br from-blue-400 to-green-200 mb-2"
                            >
                                {{ role.name }}
                            </li>
                        </ul>
                    </TableDataCell>
                    <TableDataCell class="flex space-x-2 items-center">
                        <AdminButton
                            button-text="Assign-Role"
                            button-type="assign"
                            route-name="users.assignRolePermissionToUser"
                            :obj="user"
                        />
                        <AdminButton
                            button-text="Edit"
                            button-type="edit"
                            route-name="users.edit"
                            :obj="user"
                        />
                        <AdminButton
                            button-text="Delete"
                            button-type="deleteOnConfirm"
                            route-method="delete"
                            route-name="users.destroy"
                            :obj="user"
                            text="User"
                        />
                        <AdminButton
                            button-text="Log in"
                            button-type="login"
                            route-method="post"
                            route-name="users.loginDynamically"
                            :obj="user"
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
