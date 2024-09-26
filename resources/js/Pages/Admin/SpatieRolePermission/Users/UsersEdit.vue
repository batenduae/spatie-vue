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
import UsersProfileCreate from "@/Pages/UsersInfo/UsersProfile/UsersProfileCreate.vue";

const { hasPermission,showFlash } = usePermissions();
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
    roles: ref(props.user?.assignedRoles),
    permissions: ref(props.user?.assignedPermissions),
});

onMounted(() => {
    form.roles = props.user?.assignedRoles;
    form.permissions = props.user?.assignedPermissions;
});

watch(
    (() => props.user, () => (form.roles = ref(props.user?.assignedRoles))),
    (() => props.user, () => (form.permissions = ref(props.user?.assignedPermissions)))
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

defineOptions({ layout: SpatieAdminLayout });
</script>

<template>
    <PageHeader text="Edit User" title="Users/Edit">
        <AdminButton
            button-text="Go Back"
            button-type="backward"
            route-name="users.index"
            v-if="hasPermission('user.view')"
        />
    </PageHeader>
    <Card type="cyan">
        <div class="flex flex-wrap justify-between">
            <Card class="max-w-96">
                <div class="py-4 font-semibold">User Information</div>
                <form @submit.prevent="form.put(route('users.update', user.id))">
                    <div>
                        <InputLabel for="name" value="Name" />

                        <TextInput
                            id="name"
                            type="text"
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
                            v-model="form.email"
                            required
                            autocomplete="username"
                        />

                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="mt-4" v-if="hasPermission('assign-role.to-user')">
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
                            placeholder="Assign Some Roles"
                            open-direction="bottom"
                            @tag="addTag"
                            tag-placeholder="Assign Some Roles"
                            label="name"
                            track-by="name"
                        >
                            <template slot="tag" slot-scope="props">
                                {{ form.roles }}
                            </template>
                        </multiselect>
                    </div>

                    <div class="mt-4" v-if="hasPermission('assign-permission.to-user')">
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
                            class="ms-4"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"

                            v-if="hasPermission('user.edit')"
                        >
                            Update
                        </PrimaryButton>
                    </div>
                </form>
            </Card>

            <Card v-if="props.user?.assignedRoles.length" class="">
                <div class="w-full">
                    <div class="py-4 font-semibold">Assigned Roles</div>
                    <Table>
                        <template #caption>
                            Table: User's Roles
                        </template>
                        <template #tableHeader>
                            <TableHeaderRow :contents="['ID','Name','Action']"/>
                        </template>
                        <TableRow
                            v-for="role in props.user.assignedRoles"
                            :key="role.id"
                            :contents="[role.id,role.name]"
                            narrow="narrower"
                        >
                            <TableDataCell>
                                <AdminButton
                                    button-text="Revoke"
                                    button-type="deleteOnConfirm"
                                    route-method="delete"
                                    route-name="users.revokeRole"
                                    :obj="[user, role]"
                                    :text="['User', 'Role']"
                                    v-if="hasPermission('revoke-role.from-user')"
                                />
                            </TableDataCell>
                        </TableRow>
                    </Table>
                </div>
            </Card>

            <Card v-if="props.user?.permissionsDirect.length" class="">
                <div class="w-full">
                    <div class="py-4 font-semibold">Direct Permissions</div>
                    <Table>
                        <template #caption>
                            Table: User's Direct Permissions
                        </template>
                        <template #tableHeader>
                            <TableHeaderRow :contents="['ID','Name','Action']"/>
                        </template>
                        <TableRow
                            v-for="permission in props.user?.permissionsDirect"
                            :key="permission.id"
                            :contents="[permission.id, permission.name]"
                            narrow="narrower"
                        >
                            <TableDataCell>
                                <AdminButton
                                    button-text="Revoke"
                                    button-type="deleteOnConfirm"
                                    route-method="delete"
                                    route-name="users.revokePermission"
                                    :obj="[user, permission]"
                                    :text="['User','Permission']"
                                    v-if="hasPermission('revoke-permission.from-user')"
                                />
                            </TableDataCell>
                        </TableRow>
                    </Table>
                </div>
            </Card>
        </div>
    </Card>

    <Card v-if="(props.user?.assignedPermissions.length)+(props.user?.status.length)" type="green">
        <div class="flex flex-wrap justify-around justify-items-center justify-self-center">
            <Card
                class=""
                v-if="props.user?.status.length"
            >
                <div class="py-4 font-semibold">User's Status</div>
                <Table>
                    <template #caption>
                        Table: User's All Status
                    </template>
                    <template #tableHeader>
                        <TableHeaderRow :contents="['ID','Name']"/>
                    </template>
                    <TableRow
                        v-for="(item,index) in props.user?.status"
                        :key="item"
                        :contents="[ index+1,item]"
                        narrow="narrower"
                    />
                </Table>
            </Card>

            <Card
                v-if="props.user?.assignedRoles.find((role) => role.assignedPermissions.length)"
                class=""
            >
                <div class="py-4 font-semibold">Permissions Via Roles</div>
                <Table>
                    <template #caption>
                        Table: User's Permissions Via Roles
                    </template>
                    <template #tableHeader>
                        <TableHeaderRow :contents="['ID','Role','Id','Permission']"/>
                    </template>
                    <template
                        v-for="role in props.user.assignedRoles"
                        :key="role.id"
                    >
                        <TableRow
                            v-for="permission in role.assignedPermissions"
                        >
                            <TableDataCell
                                v-if="permission === role.assignedPermissions[0]"
                                :rowspan="[role.assignedPermissions.length]"
                                narrow="narrower"
                            >
                                {{ role.id }}
                            </TableDataCell>
                            <TableDataCell
                                v-if="permission === role.assignedPermissions[0]"
                                :rowspan="[role.assignedPermissions.length]"
                            >{{ role.name }}
                            </TableDataCell>
                            <TableDataCell
                                narrow="narrower"
                            >
                                {{ permission.id }}
                            </TableDataCell>
                            <TableDataCell>
                                {{ permission.name }}
                            </TableDataCell>
                        </TableRow>
                    </template>
                </Table>
            </Card>

            <Card
                class=""
                v-if="props.user?.assignedPermissions.length"
            >
                <div class="py-4 font-semibold">All Permissions</div>
                <Table>
                    <template #caption>
                        Table: User's All Permissions
                    </template>
                    <template #tableHeader>
                        <TableHeaderRow :contents="['ID','Name','Action']"/>
                    </template>
                    <TableRow
                        v-for="permission in props.user?.assignedPermissions"
                        :key="permission.id"
                        :contents="[ permission.id,permission.name]"
                        narrow="narrower"
                    >
                        <TableDataCell>
                            <AdminButton
                                v-if="hasPermission('delete-permission.from-user') && props.user?.permissionsDirect.find((object) =>partialContains(object, permission))"
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

    <Card type="cyan">
        <UsersProfileCreate :user="user"/>
    </Card>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
<style scoped></style>
