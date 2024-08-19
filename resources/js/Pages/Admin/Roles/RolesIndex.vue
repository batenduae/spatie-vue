<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Table from "@/Components/AdminComponents/Table/Table.vue";
import TableDataCell from "@/Components/AdminComponents/Table/TableDataCell.vue";
import TableHeaderCell from "@/Components/AdminComponents/Table/TableHeaderCell.vue";
import TableRow from "@/Components/AdminComponents/Table/TableRow.vue";
defineProps(["roles"]);
defineOptions({ layout: AdminLayout });
</script>

<template>
    <Head title="Roles" />
    <div class="max-w-7xl mx-auto py-4">
        <div class="flex justify-between items-baseline">
            <h1 class="text-white">Roles Index Page</h1>
            <Link
                :href="route('roles.massAssignPermissionToRole')"
                preserve-scroll
                class="px-4 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded-lg"
            >
                Mass Assign Role Permission
            </Link>

            <Link
                :href="route('roles.create')"
                preserve-scroll
                class="px-4 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded-lg"
            >
                Create Role
            </Link>
        </div>
    </div>
    <div class="mx-auto">
        <Table>
            <template #tableHeader>
                <TableRow>
                    <TableHeaderCell>ID</TableHeaderCell>
                    <TableHeaderCell>Name</TableHeaderCell>
                    <TableHeaderCell>Action</TableHeaderCell>
                </TableRow>
            </template>
            <template #default>
                <TableRow
                    v-for="role in roles"
                    :key="role.id"
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                >
                    <TableDataCell>{{ role.id }}</TableDataCell>
                    <TableDataCell>{{ role.name }}</TableDataCell>
                    <TableDataCell class="flex space-x-2">
                        <Link
                            :href="
                                route(
                                    'roles.assignPermissionToRoleView',
                                    role.id
                                )
                            "
                            preserve-scroll
                            class="px-2 rounded-lg text-xs text-black font-bold bg-gradient-to-br from-green-500 to-blue-500"
                        >
                            Assign-permit
                        </Link>

                        <Link
                            :href="route('roles.edit', role)"
                            preserve-scroll
                            class="px-2 rounded-lg text-xs text-black font-bold bg-gradient-to-br from-purple-500 to-teal-500"
                        >
                            Edit
                        </Link>

                        <Link
                            :href="route('roles.destroy', role)"
                            method="delete"
                            as="button"
                            preserve-scroll
                            class="px-2 rounded-lg text-xs text-black font-bold bg-gradient-to-br from-red-500 to-amber-500"
                        >
                            Delete
                        </Link>
                    </TableDataCell>
                </TableRow>
            </template>
        </Table>
    </div>
</template>

<style scoped></style>
