<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Multiselect from "vue-multiselect";
import { onMounted, ref, watch } from "vue";
import Table from "@/Components/AdminComponents/Table/Table.vue";
import TableRow from "@/Components/AdminComponents/Table/TableRow.vue";
import TableDataCell from "@/Components/AdminComponents/Table/TableDataCell.vue";
import TableHeaderCell from "@/Components/AdminComponents/Table/TableHeaderCell.vue";

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
    roles: {
        type: Object,
        required: true,
    },
    permissions: {
        type: Object,
        required: true,
    },
});

function addTag(newTag) {
    const tag = {
        name: newTag,
        code: newTag.substring(0, 2) + Math.floor(Math.random() * 10000000),
    };
    this.permissions.push(tag);
    this.form.permissions.push(tag);
}

const form = useForm({
    name: props.user?.name,
    email: props.user?.email,
    roles: ref(props.user?.roles),
    permissions: ref(props.user?.permissions),
});

onMounted(() => {
    form.roles = props.user?.roles;
    form.permissions = props.user?.permissions;
});

watch(
    (() => props.user, () => (form.roles = ref(props.user?.roles))),
    (() => props.user, () => (form.permissions = ref(props.user?.permissions)))
);
// object contains subObject
function partialContains(object, subObject) {
    // Create arrays of property names
    const objProps = Object.getOwnPropertyNames(object);
    const subProps = Object.getOwnPropertyNames(subObject);

    if (subProps.length > objProps.length) {
        return false;
    }

    for (const subProp of subProps) {
        if (!object.hasOwnProperty(subProp)) {
            return false;
        }

        if (object[subProp] !== subObject[subProp]) {
            return false;
        }
    }

    return true;
}

defineOptions({ layout: AdminLayout });
</script>

<template>
    <Head title="Users/Create" />
    <div class="max-w-7xl mx-auto py-4">
        <div class="flex justify-between items-baseline">
            <h1 class="text-white text-xl font-bold">Edit User</h1>
            <Link
                :href="route('users.index')"
                class="px-4 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded-lg"
            >
                Go Back
            </Link>
        </div>
    </div>
    <div class="flex flex-wrap justify-around">
        <div
            class="my-2 w-96 p-6 rounded-lg bg-gradient-to-bl from-purple-600 to-amber-200 shadow-lg shadow-blue-500/50"
        >
            <form @submit.prevent="form.put(route('users.update', user.id))">
                <div>
                    <InputLabel for="name" value="Name" />

                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                    />

                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="mt-4">
                    <InputLabel for="email" value="Email" />

                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autocomplete="username"
                    />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mt-4">
                    <InputLabel for="role" value="Roles" />
                    <multiselect
                        id="role"
                        v-model="form.roles"
                        :options="roles"
                        :multiple="true"
                        :close-on-select="false"
                        :clear-on-select="false"
                        :preserve-search="true"
                        :searchable="true"
                        :allow-empty="true"
                        :hide-selected="true"
                        :taggable="true"
                        tag-placeholder="Assign Some Permissions"
                        open-direction="bottom"
                        @tag="addTag"
                        placeholder="Assign Some Permissions"
                        label="name"
                        track-by="name"
                    >
                        <template slot="tag" slot-scope="props">
                            {{ form.roles }}
                        </template>
                    </multiselect>
                </div>

                <div class="mt-4">
                    <InputLabel for="permission" value="Permissions" />
                    <multiselect
                        id="permission"
                        v-model="form.permissions"
                        :options="permissions"
                        :multiple="true"
                        :close-on-select="false"
                        :clear-on-select="false"
                        :preserve-search="true"
                        :searchable="true"
                        :allow-empty="true"
                        :hide-selected="true"
                        :taggable="true"
                        tag-placeholder="Assign Some Permissions"
                        open-direction="bottom"
                        @tag="addTag"
                        placeholder="Assign Some Permissions"
                        label="name"
                        track-by="name"
                    >
                        <template slot="tag" slot-scope="props">
                            {{ form.permissions }}
                        </template>
                    </multiselect>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton
                        class="ms-4"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Update
                    </PrimaryButton>
                </div>
            </form>
        </div>

        <div
            class="my-2 w-96 p-6 rounded-lg bg-gradient-to-bl from-purple-600 to-amber-200 shadow-lg shadow-blue-500/50"
        >
            <div class="max-w-xl" v-if="props.user?.roles.length">
                <div class="py-4 text-white">Assigned Roles</div>
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
                            v-for="role in props.user.roles"
                            :key="role.id"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                        >
                            <TableDataCell>{{ role.id }}</TableDataCell>
                            <TableDataCell>{{ role.name }}</TableDataCell>
                            <TableDataCell class="flex space-x-2">
                                <Link
                                    :href="
                                        route('users.revokeRole', [
                                            user.id,
                                            role.id,
                                        ])
                                    "
                                    method="delete"
                                    as="button"
                                    preserve-scroll
                                    class="px-2 rounded-lg text-xs text-black font-bold bg-gradient-to-br from-red-500 to-amber-500"
                                >
                                    Revoke
                                </Link>
                            </TableDataCell>
                        </TableRow>
                    </template>
                </Table>
            </div>
        </div>

        <div
            class="my-2 w-96 p-6 rounded-lg bg-gradient-to-bl from-purple-600 to-amber-200 shadow-lg shadow-blue-500/50"
        >
            <div class="max-w-xl" v-if="props.user?.permissions.length">
                <div class="py-4 text-white">Direct Permissions</div>
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
                            v-for="permission in props.user?.permissions"
                            :key="permission.id"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                        >
                            <TableDataCell>{{ permission.id }}</TableDataCell>
                            <TableDataCell>{{ permission.name }}</TableDataCell>
                            <TableDataCell class="flex space-x-2">
                                <Link
                                    :href="
                                        route('users.revokePermission', [
                                            user.id,
                                            permission.id,
                                        ])
                                    "
                                    method="delete"
                                    as="button"
                                    preserve-scroll
                                    class="px-2 rounded-lg text-xs text-black font-bold bg-gradient-to-br from-red-500 to-amber-500"
                                >
                                    Revoke
                                </Link>
                            </TableDataCell>
                        </TableRow>
                    </template>
                </Table>
            </div>
        </div>
    </div>

    <div
        class="m-8 p-6 rounded-lg bg-gradient-to-bl from-green-600 to-indigo-500 shadow-lg shadow-blue-500/50"
    >
        <div class="flex flex-wrap justify-around">
            <div
                class="my-4 max-w-2xl overflow-x-auto"
                v-if="props.user?.permissions.length"
            >
                <div class="py-4 text-white">Permissions from Roles</div>
                <Table>
                    <template #tableHeader>
                        <TableRow>
                            <TableHeaderCell>ID</TableHeaderCell>
                            <TableHeaderCell>Role</TableHeaderCell>
                            <TableHeaderCell>ID</TableHeaderCell>
                            <TableHeaderCell>Permission</TableHeaderCell>
                        </TableRow>
                    </template>
                    <template #default>
                        <template
                            v-for="role in props.user.roles"
                            :key="role.id"
                        >
                            <TableRow
                                v-for="permission in role.assignedPermissions"
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                            >
                                <TableDataCell
                                    v-if="
                                        permission ===
                                        role.assignedPermissions[0]
                                    "
                                    :rowspan="[role.assignedPermissions.length]"
                                    >{{ role.id }}</TableDataCell
                                >
                                <TableDataCell
                                    v-if="
                                        permission ===
                                        role.assignedPermissions[0]
                                    "
                                    :rowspan="[role.assignedPermissions.length]"
                                    >{{ role.name }}</TableDataCell
                                >
                                <TableDataCell>{{
                                    permission.id
                                }}</TableDataCell>
                                <TableDataCell>{{
                                    permission.name
                                }}</TableDataCell>
                            </TableRow>
                        </template>
                    </template>
                </Table>
            </div>

            <div
                class="my-4 max-w-2xl overflow-x-auto"
                v-if="props.user?.permissionsAll.length"
            >
                <div class="py-4 text-white">All Permissions</div>
                <Table>
                    <template #tableHeader>
                        <TableRow>
                            <TableHeaderCell>ID</TableHeaderCell>
                            <TableHeaderCell>Name</TableHeaderCell>
                            <TableHeaderCell>Role</TableHeaderCell>
                            <TableHeaderCell>Action</TableHeaderCell>
                        </TableRow>
                    </template>
                    <template #default>
                        <TableRow
                            v-for="permission in props.user?.permissionsAll"
                            :key="permission.id"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                        >
                            <TableDataCell>{{ permission.id }}</TableDataCell>
                            <TableDataCell>{{ permission.name }}</TableDataCell>
                            <TableDataCell>
                                {{ permission.name }}
                            </TableDataCell>
                            <TableDataCell class="flex space-x-2">
                                <Link
                                    v-if="
                                        props.user?.permissions.find((object) =>
                                            partialContains(object, permission)
                                        )
                                    "
                                    :href="
                                        route('users.revokePermission', [
                                            user.id,
                                            permission.id,
                                        ])
                                    "
                                    method="delete"
                                    as="button"
                                    preserve-scroll
                                    class="px-2 rounded-lg text-xs text-black font-bold bg-gradient-to-br from-red-500 to-amber-500"
                                >
                                    Revoke
                                </Link>
                            </TableDataCell>
                        </TableRow>
                    </template>
                </Table>
            </div>
        </div>
    </div>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
<style scoped></style>
