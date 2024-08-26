<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useForm } from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Multiselect from "vue-multiselect";
import { onMounted, ref, watch } from "vue";
import Table from "@/Components/AdminComponents/Table/Table.vue";
import TableRow from "@/Components/AdminComponents/Table/TableRow.vue";
import TableDataCell from "@/Components/AdminComponents/Table/TableDataCell.vue";
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import Card from "@/Components/AdminComponents/Cards/Card.vue";
import PageHeader from "@/Components/AdminComponents/Heading/PageHeader.vue";
import TableHeaderRow from "@/Components/AdminComponents/Table/TableHeaderRow.vue";

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
    <PageHeader text="Edit User" title="Users/Edit">
        <AdminButton
            button-text="Go Back"
            button-type="backward"
            route-name="users.index"
        />
    </PageHeader>
    <Card type="cyan">
        <div class="flex flex-wrap justify-between">
            <Card class="max-w-96">
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
                        <Multiselect
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
                        </Multiselect>
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
            </Card>

            <Card class="" v-if="props.user?.roles.length">
                <div class="w-full" >
                    <div class="py-4 text-white">Assigned Roles</div>
                    <Table>
                        <template #tableHeader>
                            <TableHeaderRow :contents="['ID','Name','Action']"/>
                        </template>
                        <TableRow
                            v-for="role in props.user.roles"
                            :key="role.id"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                            :contents="[role.id,role.name]"
                        >
                            <TableDataCell class="flex space-x-2">
                                <AdminButton
                                    button-text="Revoke"
                                    button-type="deleteOnConfirm"
                                    route-method="delete"
                                    route-name="users.revokeRole"
                                    :obj="[user, role]"
                                    text="User Role"
                                />
                            </TableDataCell>
                        </TableRow>
                    </Table>
                </div>
            </Card>

            <Card class="" v-if="props.user?.permissions.length">
                <div class="w-full" >
                    <div class="py-4 text-white">Direct Permissions</div>
                    <Table>
                        <template #tableHeader>
                            <TableHeaderRow :contents="['ID','Name','Action']"/>
                        </template>
                        <TableRow
                            v-for="permission in props.user?.permissions"
                            :key="permission.id"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                            :contents="[permission.id, permission.name]"
                        >
                            <TableDataCell class="flex space-x-2">
                                <AdminButton
                                    button-text="Revoke"
                                    button-type="deleteOnConfirm"
                                    route-method="delete"
                                    route-name="users.revokePermission"
                                    :obj="[user, permission]"
                                    text="User Permission"
                                />
                            </TableDataCell>
                        </TableRow>
                    </Table>
                </div>
            </Card>
        </div>
    </Card>

    <Card type="green">
        <div class="flex flex-wrap justify-around justify-items-center justify-self-center">
            <Card
                class=""
                v-if="props.user?.permissions.length"
            >
                <div class="py-4 text-white">Permissions from Roles</div>
                <Table>
                    <template #tableHeader>
                        <TableHeaderRow :contents="['ID','Role','Id','Permission']"/>
                    </template>
                    <template
                        v-for="role in props.user.roles"
                        :key="role.id"
                    >
                        <TableRow
                            v-for="permission in role.assignedPermissions"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                        >
                            <TableDataCell
                                v-if="permission === role.assignedPermissions[0]"
                                :rowspan="[role.assignedPermissions.length]"
                                >{{ role.id }}
                            </TableDataCell>
                            <TableDataCell
                                v-if="permission === role.assignedPermissions[0]"
                                :rowspan="[role.assignedPermissions.length]"
                                >{{ role.name }}
                            </TableDataCell>
                            <TableDataCell>{{permission.id }}</TableDataCell>
                            <TableDataCell>{{permission.name }}</TableDataCell>
                        </TableRow>
                    </template>
                </Table>
            </Card>

            <Card
                class=""
                v-if="props.user?.permissionsAll.length"
            >
                <div class="py-4 text-white">All Permissions</div>
                <Table>
                    <template #tableHeader>
                        <TableHeaderRow :contents="['ID','Name','Action']"/>
                    </template>
                    <TableRow
                        v-for="permission in props.user?.permissionsAll"
                        :key="permission.id"
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                        :contents="[ permission.id,permission.name]"
                    >
                        <TableDataCell class="flex space-x-2">
                           <AdminButton
                                v-if="props.user?.permissions.find((object) =>partialContains(object, permission))"
                                button-text="remove"
                                button-type="delete"
                                route-method="delete"
                                route-name="users.revokePermission"
                                :obj="[user, permission]"
                                text="User Permission"
                            />
                        </TableDataCell>
                    </TableRow>
                </Table>
            </Card>
        </div>
    </Card>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
<style scoped></style>
