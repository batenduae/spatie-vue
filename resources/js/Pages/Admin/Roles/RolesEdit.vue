<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head, Link, useForm} from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Multiselect from 'vue-multiselect'
import {ref, watch} from "vue";
import Table from "@/Components/AdminComponents/Table/Table.vue";
import TableRow from "@/Components/AdminComponents/Table/TableRow.vue";
import TableDataCell from "@/Components/AdminComponents/Table/TableDataCell.vue";
import TableHeaderCell from "@/Components/AdminComponents/Table/TableHeaderCell.vue";


const props = defineProps({
    role: {
        type: Object,
        required: true
    },
    permissions: {
        type: Object,
        required: true
    }
})

function addTag (newTag) {
    const tag = {
        name: newTag,
        code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
    }
    this.permissions.push(tag)
    this.form.permissions.push(tag)
}

const form = useForm({
    name: props.role.name,
    permissions: ref(props.role?.assignedPermissions),
})

watch(
    ()=> props.role,
    ()=> (form.permissions = ref(props.role?.assignedPermissions))
)
defineOptions({ layout: AdminLayout });
</script>

<template>
    <Head title="Roles/Edit" />
    <div class="max-w-7xl mx-auto py-4">
        <div class="flex justify-between items-baseline">
            <h1 class="text-white">Edit Role</h1>
            <Link
                :href="route('roles.index')"
                preserve-scroll
                class="px-4 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded-lg"
            >
                Go Back
            </Link>
        </div>
    </div>
    <div class="flex">
        <div class="mx-auto w-96 p-6 rounded-lg bg-gradient-to-bl from-purple-600 to-amber-200 shadow-lg shadow-blue-500/50">
            <form @submit.prevent="form.put(route('roles.update',role))">
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
                        <template
                            slot="tag"
                            slot-scope="props"
                        >
                            {{ form.permissions}}
                        </template>
                    </multiselect>
                </div>

                <div class="flex items-center justify-end mt-4">

                    <PrimaryButton class="ms-4"
                                   :class="{ 'opacity-25': form.processing }"
                                   :disabled="form.processing">
                        Update
                    </PrimaryButton>
                </div>
            </form>
        </div>

        <div v-if="props.role?.assignedPermissions.length"
             class="p-4 max-w-2xl mx-auto rounded-lg bg-gradient-to-bl from-green-600 to-indigo-500 shadow-lg shadow-blue-500/50"
        >
            <div class="py-4 text-white">Permissions To Role: {{ role.name }}</div>
            <Table>
                <template #tableHeader>
                    <TableRow>
                        <TableHeaderCell>ID</TableHeaderCell>
                        <TableHeaderCell>Name</TableHeaderCell>
                        <TableHeaderCell>Action</TableHeaderCell>
                    </TableRow>
                </template>
                <template #default>
                    <TableRow v-for="permission in props.role?.assignedPermissions" :key="permission.id"
                              class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                    >
                        <TableDataCell>{{ permission.id }}</TableDataCell>
                        <TableDataCell>{{ permission.name }}</TableDataCell>
                        <TableDataCell class="flex space-x-2">
                            <Link
                                :href="route('roles.revokePermission',[role.id, permission.id])"
                                method="delete"
                                as="button"
                                preserve-scroll
                                class="px-2 rounded-lg text-xs text-black font-bold bg-gradient-to-br from-red-500 to-amber-500 "
                            >
                                Revoke
                            </Link>
                        </TableDataCell>
                    </TableRow>
                </template>
            </Table>
        </div>
    </div>
</template>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>
<style scoped>

</style>
