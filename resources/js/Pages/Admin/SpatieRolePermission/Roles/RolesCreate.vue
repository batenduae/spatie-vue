<script setup>
import {useForm} from "@inertiajs/vue3";
import TextInput from "@/Components/Default/TextInput.vue";
import InputLabel from "@/Components/Default/InputLabel.vue";
import InputError from "@/Components/Default/InputError.vue";
import PrimaryButton from "@/Components/Default/PrimaryButton.vue";
import Multiselect from "vue-multiselect";
import Table from "@/Components/AdminComponents/Table/Table.vue";
import TableRow from "@/Components/AdminComponents/Table/TableRow.vue";
import TableDataCell from "@/Components/AdminComponents/Table/TableDataCell.vue";
import TableHeaderCell from "@/Components/AdminComponents/Table/TableHeaderCell.vue";
import {onMounted, onUpdated, ref} from "vue";
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import PageHeader from "@/Components/AdminComponents/Heading/PageHeader.vue";
import {usePermissions} from "@/composables/permissions.js";
import SpatieAdminLayout from "@/Layouts/SpatieAdminLayout.vue";

const { hasPermission,showFlash } = usePermissions();
onMounted(showFlash)
onUpdated(showFlash)
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
    group: "",
    description: "",
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
            v-if="hasPermission('roles.index')"
        />
    </PageHeader>
    <div class="flex">
        <div
            class="mx-auto w-96 p-6 rounded-lg bg-gradient-to-bl from-purple-600 to-amber-200 shadow-lg shadow-blue-500/50"
        >
            <form @submit.prevent="form.post(route('roles.store'))">
                <div>
                    <InputLabel for="name" value="Role Name"/>

                    <TextInput
                        id="name"
                        v-model="form.name"
                        type="text"
                        autocomplete="name"
                        required
                        autofocus
                        fluid
                    />

                    <InputError :message="form.errors.name" class="mt-2"/>
                </div>

                <div>
                    <InputLabel for="group" value="Group"/>

                    <TextInput
                        id="group"
                        v-model="form.group"
                        fluid
                        autocomplete="group"
                        required
                        type="text"
                    />

                    <InputError :message="form.errors.group" class="mt-2"/>
                </div>

                <div>
                    <InputLabel for="description" value="Description"/>

                    <TextArea
                        id="description"
                        v-model="form.description"
                        fluid
                        autocomplete="description"
                        required
                        type="text"
                    />

                    <InputError :message="form.errors.description" class="mt-2"/>
                </div>

                <div v-if="hasPermission('roles.assign.permission')" class="mt-4">
                    <InputLabel for="permission" value="Permissions"/>
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
                        fluid
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
                        v-if="hasPermission('roles.create')"
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
                        <TableHeaderCell>Group</TableHeaderCell>
                        <TableHeaderCell>Description</TableHeaderCell>
                        <TableHeaderCell>Action</TableHeaderCell>
                    </TableRow>
                </template>
                <TableRow
                    v-for="permission in form.permissions"
                    :key="permission.id"
                    :contents="[permission.id,permission.name,permission.group,permission.description]"
                >
                    <TableDataCell>
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
