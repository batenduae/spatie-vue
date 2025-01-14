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
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import PageHeader from "@/Components/AdminComponents/Heading/PageHeader.vue";
import {useForm} from "@inertiajs/vue3";
import Card from "@/Components/AdminComponents/Cards/Card.vue";
import {usePermissions} from "@/composables/permissions.js";
import SpatieAdminLayout from "@/Layouts/SpatieAdminLayout.vue";
import TableHeaderRow from "@/Components/AdminComponents/Table/TableHeaderRow.vue";

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
    group: props.role.group,
    description: props.role.description,
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
            v-if="hasPermission('roles.index')"
        />
    </PageHeader>
    <div class="flex flex-wrap justify-between">
        <Card type="orange" class="w-96">
            <form @submit.prevent="form.put(route('roles.update', role))">
                <div v-if="hasPermission(['roles.edit'])">

                    <div>
                        <InputLabel for="name" value="Role Name"/>

                        <TextInput
                            id="name"
                            v-model="form.name"
                            autocomplete="name"
                            autofocus
                            class="mt-1 block w-full"
                            required
                            type="text"
                        />

                        <InputError :message="form.errors.name" class="mt-2"/>
                    </div>

                    <div>
                        <InputLabel for="group" value="Group"/>

                        <TextInput
                            id="group"
                            v-model="form.group"
                            autocomplete="group"
                            autofocus
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
                            autocomplete="description"
                            autofocus
                            required
                            type="text"
                        />

                        <InputError :message="form.errors.description" class="mt-2"/>
                    </div>

                </div>

                <div v-if="hasPermission(['roles.sync.permission'])" class="mt-4">
                    <InputLabel for="permission" value="Permissions"/>
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
                        v-if="hasPermission(['roles.edit','roles.sync.permission'])"
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
                <template #caption>
                    Table: Role's Permissions
                </template>
                <template #tableHeader>
                    <TableHeaderRow
                        :contents="['ID','Name','Action']"
                    />
                </template>
                <TableRow
                    v-for="permission in props.role?.assignedPermissions"
                    :key="permission.id"
                    :contents="[permission.id,permission.name]"
                    narrow="narrower"
                >
                    <TableDataCell>
                        <AdminButton
                            button-text="Revoke"
                            button-type="deleteOnConfirm"
                            route-method="delete"
                            route-name="roles.revokePermission"
                            :obj="[role,permission]"
                            :text="['Role','Permission']"
                            v-if="hasPermission('roles.revoke.permission')"
                        />
                    </TableDataCell>
                </TableRow>
            </Table>
        </Card>
    </div>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
<style scoped></style>
