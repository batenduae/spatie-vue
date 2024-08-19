<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Table from "@/Components/AdminComponents/Table/Table.vue";
import TableHeaderCell from "@/Components/AdminComponents/Table/TableHeaderCell.vue";
import TableRow from "@/Components/AdminComponents/Table/TableRow.vue";
import TableDataCell from "@/Components/AdminComponents/Table/TableDataCell.vue";
defineProps(["users"]);
defineOptions({ layout: AdminLayout });
</script>

<template>
    <Head title="Users" />
    <div class="max-w-7xl mx-auto py-4">
        <div class="flex justify-between items-baseline">
            <h1 class="text-white text-xl">Users Index Page</h1>
            <Link
                :href="route('users.create')"
                preserve-scroll
                class="px-4 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded-lg"
            >
                Create User
            </Link>
        </div>
    </div>
    <div class="mx-auto">
        <div class="">
            <Table>
                <template #tableHeader>
                    <TableRow>
                        <TableHeaderCell>ID</TableHeaderCell>
                        <TableHeaderCell>Name</TableHeaderCell>
                        <TableHeaderCell>Email</TableHeaderCell>
                        <TableHeaderCell>Roles</TableHeaderCell>
                        <TableHeaderCell>Action</TableHeaderCell>
                    </TableRow>
                </template>
                <template #default>
                    <TableRow
                        v-for="user in users"
                        :key="user.id"
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                    >
                        <TableDataCell class="items-center">{{
                            user.id
                        }}</TableDataCell>
                        <TableDataCell class="items-center">{{
                            user.name
                        }}</TableDataCell>
                        <TableDataCell class="items-center">{{
                            user.email
                        }}</TableDataCell>
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
                            <Link
                                :href="
                                    route(
                                        'users.assignRolePermissionToUser',
                                        user.id
                                    )
                                "
                                preserve-scroll
                                class="px-2 rounded-lg text-xs text-black font-bold bg-gradient-to-br from-green-500 to-blue-500"
                            >
                                Assign-Role
                            </Link>

                            <Link
                                :href="route('users.edit', user.id)"
                                preserve-scroll
                                class="px-2 rounded-lg text-xs text-black font-bold bg-gradient-to-br from-purple-500 to-teal-500"
                            >
                                Edit
                            </Link>

                            <Link
                                :href="route('users.destroy', user.id)"
                                method="delete"
                                as="button"
                                preserve-scroll
                                class="px-2 rounded-lg text-xs text-black font-bold bg-gradient-to-br from-red-500 to-amber-500"
                            >
                                Delete
                            </Link>

                            <Link
                                :href="route('users.loginDynamically', user.id)"
                                method="post"
                                as="button"
                                preserve-scroll
                                class="px-2 rounded-lg text-xs text-black font-bold bg-gradient-to-br from-fuchsia-500 to-indigo-500"
                            >
                                Login
                            </Link>
                        </TableDataCell>
                    </TableRow>
                </template>
            </Table>
        </div>
    </div>
</template>

<style scoped></style>
