<script setup>
import TextInput from "@/Components/Default/TextInput.vue";
import InputLabel from "@/Components/Default/InputLabel.vue";
import InputError from "@/Components/Default/InputError.vue";
import PrimaryButton from "@/Components/Default/PrimaryButton.vue";
import Multiselect from "vue-multiselect";
import {onMounted, onUpdated, ref, watch} from "vue";
import Table from "@/Components/AdminComponents/Table/Table.vue";
import TableRow from "@/Components/AdminComponents/Table/TableRow.vue";
import TableDataCell from "@/Components/AdminComponents/Table/TableDataCell.vue";
import TableHeaderCell from "@/Components/AdminComponents/Table/TableHeaderCell.vue";
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import PageHeader from "@/Components/AdminComponents/Heading/PageHeader.vue";
import {useForm} from "@inertiajs/vue3";
import Card from "@/Components/AdminComponents/Cards/Card.vue";
import {usePermissions} from "@/composables/permissions.js";
import SpatieAdminLayout from "@/Layouts/SpatieAdminLayout.vue";

const { hasPermission,showFlash } = usePermissions();
onMounted(showFlash)
onUpdated(showFlash)
const props = defineProps({
    role: {
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
    name: props.role.name,
    permissions: ref(props.role?.assignedPermissions),
});

watch(
    () => props.role,
    () => (form.permissions = ref(props.role?.assignedPermissions))
);
defineOptions({ layout: SpatieAdminLayout });
</script>

<template>
    <PageHeader text="Edit Role" title="Roles/Edit">
        <AdminButton
            button-text="Go Back"
            button-type="backward"
            route-name="roles.index"
            v-if="hasPermission('role.view')"
        />
    </PageHeader>
    <div class="flex flex-wrap justify-between">
        <Card type="orange" class="w-96">
            <form @submit.prevent="form.put(route('roles.update', role))">
                <div>
                    <InputLabel for="role" value="Role" />

                    <TextInput
                        id="role"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                    />

                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="mt-4" v-if="hasPermission('assign-permission.to-role')">
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
                        @click="push.success('Role Updated Successfully')"
                        v-if="hasPermission(['role.edit','assign-permission.to-role'])"
                    >
                        Update
                    </PrimaryButton>
                </div>
            </form>
        </Card>

        <Card type="green" v-if="props.role?.assignedPermissions.length">
            <div class="py-4 text-white">
                Permissions To Role: {{ role.name }}
            </div>
            <Table>
                <template #tableHeader>
                    <TableRow>
                        <TableHeaderCell>ID</TableHeaderCell>
                        <TableHeaderCell>Name</TableHeaderCell>
                        <TableHeaderCell>Action</TableHeaderCell>
                    </TableRow>
                </template>
                <TableRow
                    v-for="permission in props.role?.assignedPermissions"
                    :key="permission.id"
                    :contents="[permission.id,permission.name]"
                >
                    <TableDataCell class="flex space-x-2">
                        <AdminButton
                            button-text="Revoke"
                            button-type="deleteOnConfirm"
                            route-method="delete"
                            route-name="roles.revokePermission"
                            :obj="[role,permission]"
                            :text="['Role','Permission']"
                            v-if="hasPermission('revoke-permission.from-role')"
                        />
                    </TableDataCell>
                </TableRow>
            </Table>
        </Card>
    </div>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
<style scoped></style>
