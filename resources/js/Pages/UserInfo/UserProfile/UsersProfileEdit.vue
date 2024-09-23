<script setup>
import {useForm} from "@inertiajs/vue3";
import TextInput from "@/Components/Default/TextInput.vue";
import InputLabel from "@/Components/Default/InputLabel.vue";
import InputError from "@/Components/Default/InputError.vue";
import PrimaryButton from "@/Components/Default/PrimaryButton.vue";
import Multiselect from "vue-multiselect";
import {onMounted, onUpdated, ref, watch} from "vue";
import Table from "@/Components/AdminComponents/Table/Table.vue";
import TableRow from "@/Components/AdminComponents/Table/TableRow.vue";
import TableDataCell from "@/Components/AdminComponents/Table/TableDataCell.vue";
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import Card from "@/Components/AdminComponents/Cards/Card.vue";
import PageHeader from "@/Components/AdminComponents/Heading/PageHeader.vue";
import TableHeaderRow from "@/Components/AdminComponents/Table/TableHeaderRow.vue";
import {usePermissions} from "@/composables/permissions.js";
import SpatieAdminLayout from "@/Layouts/SpatieAdminLayout.vue";

const {hasPermission, showFlash} = usePermissions();
onMounted(showFlash)
onUpdated(showFlash)
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
    status: ref(props.user?.status),
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

defineOptions({layout: SpatieAdminLayout});
</script>

<template>
    <PageHeader text="Edit User" title="Users/Edit">
        <AdminButton
            v-if="hasPermission('user.view')"
            button-text="Go Back"
            button-type="backward"
            route-name="users.index"
        />
    </PageHeader>
    <Card type="cyan">
        <div class="flex flex-wrap justify-between">
            <Card class="max-w-96">
                <div class="py-4 font-semibold">User Information</div>
                <form @submit.prevent="form.put(route('users.update', user.id))">
                    <div>
                        <InputLabel for="name" value="Name"/>

                        <TextInput
                            id="name"
                            v-model="form.name"
                            autocomplete="name"
                            autofocus
                            required
                            type="text"
                        />

                        <InputError :message="form.errors.name" class="mt-2"/>
                    </div>

                    <div class="mt-4">
                        <InputLabel for="email" value="Email"/>

                        <TextInput
                            id="email"
                            v-model="form.email"
                            autocomplete="username"
                            required
                            type="email"
                        />

                        <InputError :message="form.errors.email" class="mt-2"/>
                    </div>

                    <div v-if="hasPermission('assign-role.to-user')" class="mt-4">
                        <InputLabel for="role" value="Roles"/>
                        <multiselect
                            id="role"
                            v-model="form.roles"
                            :allow-empty="true"
                            :clear-on-select="false"
                            :close-on-select="false"
                            :hide-selected="true"
                            :multiple="true"
                            :options="roles"
                            :preserve-search="true"
                            :searchable="true"
                            :taggable="true"
                            label="name"
                            open-direction="bottom"
                            placeholder="Assign Some Roles"
                            tag-placeholder="Assign Some Roles"
                            track-by="name"
                            @tag="addTag"
                        >
                            <template slot="tag" slot-scope="props">
                                {{ form.roles }}
                            </template>
                        </multiselect>
                    </div>

                    <div v-if="hasPermission('assign-permission.to-user')" class="mt-4">
                        <InputLabel for="permission" value="Permissions"/>
                        <Multiselect
                            id="permission"
                            v-model="form.permissions"
                            :allow-empty="true"
                            :clear-on-select="false"
                            :close-on-select="false"
                            :hide-selected="true"
                            :multiple="true"
                            :options="permissions"
                            :preserve-search="true"
                            :searchable="true"
                            :taggable="true"
                            label="name"
                            open-direction="bottom"
                            placeholder="Assign Some Permissions"
                            tag-placeholder="Assign Some Permissions"
                            track-by="name"
                            @tag="addTag"
                        >
                            <template slot="tag" slot-scope="props">
                                {{ form.permissions }}
                            </template>
                        </Multiselect>
                    </div>

                    <div v-if="hasPermission('assign-permission.to-user')" class="mt-4">
                        <InputLabel for="status" value="Status"/>
                        <Multiselect
                            id="status"
                            v-model="form.status"
                            :allow-empty="true"
                            :clear-on-select="false"
                            :close-on-select="false"
                            :hide-selected="true"
                            :multiple="true"
                            :options="['asp']"
                            :preserve-search="true"
                            :searchable="true"
                            :taggable="true"
                            open-direction="bottom"
                            placeholder="Assign Some Status"
                            tag-placeholder="Assign Some Status"
                            @tag="addTag"

                        >
                            <template slot="tag" slot-scope="props">
                                {{ form.permissions }}
                            </template>
                        </Multiselect>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <PrimaryButton
                            v-if="hasPermission('user.edit')"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"

                            class="ms-4"
                        >
                            Update
                        </PrimaryButton>
                    </div>
                </form>
            </Card>

            <Card v-if="props.user?.roles.length" class="">
                <div class="w-full">
                    <div class="py-4 font-semibold">Assigned Roles</div>
                    <Table>
                        <template #tableHeader>
                            <TableHeaderRow :contents="['ID','Name','Action']"/>
                        </template>
                        <TableRow
                            v-for="role in props.user.roles"
                            :key="role.id"
                            :contents="[role.id,role.name]"
                        >
                            <TableDataCell class="flex space-x-2">
                                <AdminButton
                                    v-if="hasPermission('revoke-role.from-user')"
                                    :obj="[user, role]"
                                    :text="['User', 'Role']"
                                    button-text="Revoke"
                                    button-type="deleteOnConfirm"
                                    route-method="delete"
                                    route-name="users.revokeRole"
                                />
                            </TableDataCell>
                        </TableRow>
                    </Table>
                </div>
            </Card>

            <Card v-if="props.user?.permissions.length" class="">
                <div class="w-full">
                    <div class="py-4 font-semibold">Direct Permissions</div>
                    <Table>
                        <template #tableHeader>
                            <TableHeaderRow :contents="['ID','Name','Action']"/>
                        </template>
                        <TableRow
                            v-for="permission in props.user?.permissions"
                            :key="permission.id"
                            :contents="[permission.id, permission.name]"
                        >
                            <TableDataCell class="flex space-x-2">
                                <AdminButton
                                    v-if="hasPermission('revoke-permission.from-user')"
                                    :obj="[user, permission]"
                                    :text="['User','Permission']"
                                    button-text="Revoke"
                                    button-type="deleteOnConfirm"
                                    route-method="delete"
                                    route-name="users.revokePermission"
                                />
                            </TableDataCell>
                        </TableRow>
                    </Table>
                </div>
            </Card>
        </div>
    </Card>

    <Card v-if="(props.user?.permissions.length)+(props.user?.permissionsAll.length)" type="green">
        <div class="flex flex-wrap justify-around justify-items-center justify-self-center">
            <Card
                v-if="props.user?.roles.find((role) => role.assignedPermissions.length)"
                class=""
            >
                <div class="py-4 font-semibold">Permissions from Roles</div>
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
                            <TableDataCell>{{ permission.id }}</TableDataCell>
                            <TableDataCell>{{ permission.name }}</TableDataCell>
                        </TableRow>
                    </template>
                </Table>
            </Card>

            <Card
                v-if="props.user?.permissionsAll.length"
                class=""
            >
                <div class="py-4 font-semibold">All Permissions</div>
                <Table>
                    <template #tableHeader>
                        <TableHeaderRow :contents="['ID','Name','Action']"/>
                    </template>
                    <TableRow
                        v-for="permission in props.user?.permissionsAll"
                        :key="permission.id"
                        :contents="[ permission.id,permission.name]"
                    >
                        <TableDataCell class="flex space-x-2">
                            <AdminButton
                                v-if="hasPermission('delete-permission.from-user') && props.user?.permissions.find((object) =>partialContains(object, permission))"
                                :obj="[user, permission]"
                                button-text="remove"
                                button-type="delete"
                                route-method="delete"
                                route-name="users.revokePermission"
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
