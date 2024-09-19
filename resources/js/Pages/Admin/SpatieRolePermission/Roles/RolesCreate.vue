<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useForm } from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Multiselect from "vue-multiselect";
import Table from "@/Components/AdminComponents/Table/Table.vue";
import TableRow from "@/Components/AdminComponents/Table/TableRow.vue";
import TableDataCell from "@/Components/AdminComponents/Table/TableDataCell.vue";
import TableHeaderCell from "@/Components/AdminComponents/Table/TableHeaderCell.vue";
import { ref } from "vue";
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import PageHeader from "@/Components/AdminComponents/Heading/PageHeader.vue";
import {usePermissions} from "@/composables/permissions.js";
import SpatieAdminLayout from "@/Layouts/SpatieAdminLayout.vue";
const { hasPermission } = usePermissions();
const props = defineProps({
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
    name: "",
    permissions: ref([]),
});

function revokePermission(id) {
    let obj = this.form.permissions;
    obj.splice(
        obj.findIndex((a) => a.id === id),
        1
    );
}
defineOptions({ layout: SpatieAdminLayout });
</script>

<template>
    <PageHeader text="Create Role" title="Roles/Create">
        <AdminButton
            button-text="Go Back"
            button-type="backward"
            route-name="roles.index"
            v-if="hasPermission('role.view')"
        />
    </PageHeader>
    <div class="flex">
        <div
            class="mx-auto w-96 p-6 rounded-lg bg-gradient-to-bl from-purple-600 to-amber-200 shadow-lg shadow-blue-500/50"
        >
            <form @submit.prevent="form.post(route('roles.store'))">
                <div>
                    <InputLabel for="role" value="Role" />

                    <TextInput
                        id="role"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="role"
                    />

                    <InputError class="mt-2" :message="form.errors.name" />
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
                        v-if="hasPermission('role.create')"
                    >
                        Create
                    </PrimaryButton>
                </div>
            </form>
        </div>

        <div
            v-if="form.permissions.length"
            class="p-4 max-w-2xl mx-auto rounded-lg bg-gradient-to-bl from-green-600 to-indigo-500 shadow-lg shadow-blue-500/50"
        >
            <div class="py-4 text-white">Permissions</div>
            <Table>
                <template #tableHeader>
                    <TableRow>
                        <TableHeaderCell>ID</TableHeaderCell>
                        <TableHeaderCell>Name</TableHeaderCell>
                        <TableHeaderCell>Action</TableHeaderCell>
                    </TableRow>
                </template>
                <TableRow
                    v-for="permission in form.permissions"
                    :key="permission.id"
                    :contents="[permission.id,permission.name]"
                >
                    <TableDataCell class="flex space-x-2">
                        <button
                            v-on:click="revokePermission(permission.id)"
                            class="px-2 rounded-lg text-xs text-black font-bold bg-gradient-to-br from-red-500 to-amber-500"
                        >
                            Revoke
                        </button>
                    </TableDataCell>
                </TableRow>
            </Table>
        </div>
    </div>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
<style scoped></style>
