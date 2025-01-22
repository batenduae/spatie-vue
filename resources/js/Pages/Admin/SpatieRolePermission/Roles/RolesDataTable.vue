<script setup>
import {ref} from 'vue';
import {FilterMatchMode} from '@primevue/core/api';
import {useToast} from 'primevue/usetoast';
import {usePermissions} from "@/composables/permissions.js";
import {useForm} from "@inertiajs/vue3";
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";

const {hasPermission, hasPermissionSelf, hasPermissionOthers, hasRole, showFlash} = usePermissions();
//
const props = defineProps([
    'roles',
])
const toast = useToast();
const dt = ref();
const roles = ref();
roles.value = props.roles;

const filters = ref({
    'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
});

//For create new role
let role = ref({});
const roleDialog = ref(false);
const submitted = ref(false);

const createNewRole = () => {
    role = {};
    submitted.value = false;
    roleDialog.value = true;
};

const hideDialog = () => {
    roleDialog.value = false;
    submitted.value = false;
};

function updateRole(roleId) {
    role = props.roles.filter((item) => {
        return (item.id === roleId)
    })[0];
    submitted.value = false;
    roleDialog.value = true;
}
const saveRole = () => {
    submitted.value = true;
    let form = useForm({
        name: ref(role.name),
        group: ref(role.group),
        description: ref(role.description),
    });
    if (!role?.id && role?.name.trim()) {
        form.post(route('roles.store'))
        toast.add({severity: 'success', summary: 'Successful', detail: 'Role Created', life: 3000});
        roleDialog.value = false;
        role = {};
    } else {
        form.put(route('roles.update', role.id))
        toast.add({severity: 'success', summary: 'Successful', detail: 'Role Updated', life: 3000});
        roleDialog.value = false;
        role.value = {};
    }
};
let selectedRole = ref();
const deleteRoleDialog = ref(false);

function confirmDeleteRole(id) {
    selectedRole = id;
    submitted.value = false;
    deleteRoleDialog.value = true;
}

const deleteRole = () => {
    deleteRoleDialog.value = false;
    let ids = [selectedRole];
    let filteredIds = [...new Set([...hasPermissionSelf('roles.delete', ids), ...hasPermissionOthers('roles.delete', ids)])].filter((value) => value > 0);
    const form = useForm({
        ids: filteredIds,
    });
    form.delete(route('roles.destroyMany', filteredIds))
    selectedRole = null;
    toast.add({severity: 'success', summary: 'Successful', detail: 'Role Deleted', life: 3000});
};

//for batch mode operation
//to delete role
let selectedRoles = ref();
const deleteRolesDialog = ref(false);
const confirmDeleteSelected = () => {
    deleteRolesDialog.value = true;
};
const deleteSelectedRoles = () => {
    deleteRolesDialog.value = false;
    let ids = selectedRoles.value.map(({id}) => id);
    let filteredIds = [...new Set([...hasPermissionSelf('roles.delete', ids), ...hasPermissionOthers('roles.delete', ids)])].filter((value) => value > 0);
    const form = useForm({
        ids: filteredIds,
    });
    form.delete(route('roles.destroyMany', filteredIds))
    selectedRoles.value = null;
    toast.add({severity: 'success', summary: 'Successful', detail: 'Roles Deleted', life: 3000});
};

const exportCSV = () => {
    dt.value.exportCSV();
};

const multiSortMeta = ref(
    [
        {field: 'id', order: -1},
    ]
);

</script>

<template>
    <div v-if="hasPermission('roles.index')" class="">
        <div v-if="roles.length" class="mx-auto">
            <div class="card mb-4">
                <!--            For operation-->
                <Toolbar class="mb-6">
                    <template #start>
                        <!--                    create new role-->
                        <Button v-if="hasPermission('roles.create')" class="mr-2" icon="pi pi-plus"
                                label="Create Role"
                                @click="createNewRole"/>
                        <Button :disabled="!selectedRoles || !selectedRoles.length" icon="pi pi-trash"
                                label="Delete"
                                outlined severity="danger"
                                @click="confirmDeleteSelected"
                        />

                    </template>

                    <template #end>
                        <FileUpload :chooseButtonProps="{ severity: 'secondary' }" :maxFileSize="1000000" accept="image/*"
                                    auto chooseLabel="Import"
                                    class="mr-2" customUpload label="Import" mode="basic"/>
                        <Button icon="pi pi-upload" label="Export" severity="secondary" @click="exportCSV($event)"/>
                    </template>
                </Toolbar>

                <!--            show chart-->
                <DataTable
                    ref="dt"
                    v-model:selection="selectedRoles"
                    :filters="filters"
                    :paginator="true"
                    :multiSortMeta="multiSortMeta"
                    :rowsPerPageOptions="[5, 10, 25, 50, 100]"
                    :value="props.roles"
                    currentPageReportTemplate="Showing {first} to {last} of {totalRecords} roles from Page {currentPage} of {totalPages}"
                    dataKey="id"
                    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown JumpToPageInput"
                    :rows="5"
                    removableSort
                    scrollHeight="400px"
                    scrollable
                    sortMode="multiple"
                    showGridlines
                    size="small"
                    stripedRows

                >
                    <template #header>
                        <div class="flex flex-wrap gap-2 items-center justify-between">
                            <h4 class="m-0">Manage Roles</h4>
                            <IconField>
                                <InputIcon>
                                    <i class="pi pi-search"/>
                                </InputIcon>
                                <InputText v-model="filters['global'].value" placeholder="Search..."/>
                            </IconField>
                        </div>
                    </template>


                    <Column :exportable="false" selectionMode="multiple" style="width: 2rem"></Column>
                    <Column field="id" header="Id" sortable style="min-width: 2rem"></Column>
                    <Column field="name" header="Role Name" sortable style="min-width: 2rem"></Column>
                    <Column field="group" header="Role Group" sortable style="min-width: 2rem"></Column>
                    <Column field="description" header="Role Description" style="min-width: 2rem"></Column>
                    <Column :exportable="false" header="Action" style="min-width: 3rem">
                        <template #body="slotProps">
                            <div class="flex justify-start space-x-2">
                                <Button v-if="hasPermission('roles.edit')" class="mr-2" icon="pi pi-pencil"
                                        label=""
                                        @click="updateRole(slotProps.data.id)"/>
                                <Button v-if="hasPermission('roles.delete')" class="mr-2" icon="pi pi-trash"
                                        label=""
                                        @click="confirmDeleteRole(slotProps.data.id)"/>
                                <AdminButton
                                    v-if="hasPermission(['roles.sync.permission'])"
                                    :obj="slotProps.data.id"
                                    button-text="sync-permit"
                                    button-type="assign"
                                    route-name="roles.syncPermissionView"
                                />
                            </div>
                        </template>
                    </Column>
                </DataTable>
            </div>

            <Dialog v-model:visible="roleDialog" :modal="true" :style="{ width: '450px' }"
                    header="Role Details">
                <div class="flex flex-col gap-6">
                    <div>
                        <label class="block font-bold mb-3" for="name">Name</label>
                        <InputText
                            id="name" v-model.trim="role.name" :invalid="submitted && !role.name"
                            autofocus fluid
                            required="true"
                        />
                        <small v-if="submitted && !role.name" class="text-red-500">Name is required.</small>
                    </div>

                    <div>
                        <label class="block font-bold mb-3" for="group">Group</label>
                        <InputText
                            id="group" v-model.trim="role.group" :invalid="submitted && !role.group"
                            fluid
                        />
                        <!--                    <small v-if="submitted && !role.group" class="text-red-500">group is required.</small>-->
                    </div>

                    <div>
                        <label class="block font-bold mb-3" for="description">Description</label>
                        <Textarea
                            id="description" v-model.trim="role.description" :invalid="submitted && !role.description"
                            fluid
                        />
                        <!--                    <small v-if="submitted && !role.description" class="text-red-500">group is required.</small>-->
                    </div>


                </div>

                <template #footer>
                    <Button icon="pi pi-times" label="Cancel" text @click="hideDialog"/>
                    <Button icon="pi pi-check" label="Save" @click="saveRole"/>
                </template>
            </Dialog>

            <Dialog v-model:visible="deleteRoleDialog" :modal="true" :style="{ width: '450px' }" header="Confirm">
                <div class="flex items-center gap-4">
                    <i class="pi pi-exclamation-triangle !text-3xl"/>
                    <span v-if="role">Are you sure you want to delete <b>{{ role.name }}</b>?</span>
                </div>
                <template #footer>
                    <Button icon="pi pi-times" label="No" text @click="deleteRoleDialog = false"/>
                    <Button icon="pi pi-check" label="Yes" @click="deleteRole"/>
                </template>
            </Dialog>

            <Dialog v-model:visible="deleteRolesDialog" :modal="true" :style="{ width: '450px' }" header="Confirm">
                <div class="flex items-center gap-4">
                    <i class="pi pi-exclamation-triangle !text-3xl"/>
                    <span v-if="role">Are you sure you want to delete the selected roles?</span>
                </div>
                <template #footer>
                    <Button icon="pi pi-times" label="No" text @click="deleteRolesDialog = false"/>
                    <Button icon="pi pi-check" label="Yes" text @click="deleteSelectedRoles"/>
                </template>
            </Dialog>
        </div>
        <div v-else class="">
            <div
                class="text-xl text-white bg-gradient-to-br from-pink-300 to-rose-600 rounded-lg p-4 max-w-xl text-center mx-auto">
                No Role Found
            </div>
        </div>
    </div>
    <div v-else class="">
        <div
            class="text-xl text-white bg-gradient-to-br from-pink-300 to-rose-600 rounded-lg p-4 max-w-xl text-center mx-auto">
            You are not allowed to access Role Datatable
        </div>
    </div>
</template>


